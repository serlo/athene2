/**
 *
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author  Julian Kempff (julian.kempff@serlo.org)
 * @license LGPL-3.0
 * @license http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
/*global define, require, MathJax*/
define("ATHENE2-EDITOR", ['jquery', 'underscore', 'events', 'content', 'shortcuts', 'spoiler'],
    function ($, _, eventScope, Content, Shortcuts) {
        "use strict";
        var $body = $('body'),
            $window = $(window),
            Editor;

        function getCompleteToken(editor, pos, maxLines, currentToken, firstRun) {
            var prevStartPos = {};

            function loop(pos, maxLines, currentToken, firstRun) {
                // Get the token at current position
                var token = editor.getTokenAt(pos),
                    endPos;

                // Check if it's the other one than before
                if ((_.isEqual(token.state.startPos, prevStartPos && !firstRun)) ||
                    (!_.isEqual(token.state.startPos, prevStartPos && firstRun))) {

                    if (token.state.endPos) {
                        // YIPPIE, COMPLETE NEW TOKEN
                        return token;
                    }
                    // D'oh, endPos is missing, let's have a look

                    // We're in the last line, let's stop here
                    if (maxLines <= pos.line) {
                        endPos = {
                            ch: token.end,
                            line: pos.line
                        };
                        // Dunno what'll happen, let's try
                        return token;
                    }

                    // Let's save the current Token startPos as a reference
                    prevStartPos = token.state.startPos;

                    // Now call this function again
                    pos.line++;
                    pos.ch = 1;
                    return loop(pos, maxLines, token, false);
                }

                return currentToken;
            }

            return loop(pos, maxLines, currentToken, firstRun);
        }

        Editor = function (settings) {
            this.helpers = [];
            eventScope(this);

            Content.add(function (context) {
                var $context = $(context);

                MathJax.Hub.Queue(["Typeset", MathJax.Hub, context]);

                if ($context.parents('.spoiler').length) {
                    $context.parents('.spoiler').Spoiler();
                } else if ($context.hasClass('spoiler')) {
                    $context.Spoiler();
                } else {
                    $('.spoiler', $context).Spoiler();
                }

                // init injections
                /*if ($context.parents('.injection').length) {
                    $context.parents('.injection').Injections();
                } else if ($context.hasClass('injection')) {
                    $context.Injections();
                } else {
                    $('.injection', $context).Injections();
                }*/
            });

            return this.updateSettings(settings);
        };

        Editor.prototype.updateSettings = function (settings) {
            return $.extend(this, settings);
        };

        Editor.prototype.initialize = function () {
            var that = this;

            $window.resize(function () {
                that.resize();
            }).resize();

            that.$pluginWrapper = $('<div class="editor-plugin-wrapper">');

            that.initKeyshortCuts(new Shortcuts());

            that.textEditor.on('change', _.throttle(function () {
                if (that.editable) {
                    var value = that.textEditor.getValue(),
                        patch = that.editable.update(value, that.parser.parse(value));

                    if (patch.type !== "identical" && patch.replace.length > 0) {
                        _.each(patch.replace, function (el) {
                            if (el.innerHTML) {
                                Content.init(el);
                            }
                        });
                    }
                }
            }, 150));

            that.textEditor.on('cursorActivity', _.throttle(function () {
                var cursor = that.textEditor.getCursor();

                that.textEditor.operation(function () {
                    var token = that.textEditor.getTokenAt(cursor);

                    if (!that.currentToken || !_.isEqual(that.currentToken, token)) {
                        token.line = cursor.line;
                        that.currentToken = token;
                        that.trigger('tokenChange', token);
                    }
                });

            }, 400));

            that.textEditor.on('cursorActivity', _.throttle(function () {
                if (that.editable) {
                    that.preview.scrollSync(that.editable.$el,
                        that.textEditor.getCursor().line / that.textEditor.lastLine());
                }
            }, 1500));

            that.addEventListener('tokenChange', function (token) {
                var state = token.type,
                    plugin;

                that.pluginManager.deactivate();

                if (that.$widget) {
                    that.$widget.remove();
                }

                if (!that.textEditor.hidePlugins && state) {
                    state = _.first(token.type.split(' '));
                    plugin = that.pluginManager.matchState(state);
                    if (plugin) {
                        that.$widget = plugin.getActivateLink();
                        that.$widget.click(function () {
                            var maxLines = that.textEditor.doc.size;

                            that.$widget.remove();
                            that.$widget = null;

                            that.currentToken =
                                getCompleteToken(that.textEditor, that.textEditor.getCursor(), maxLines, {}, true);

                            that.currentToken.state.string =
                                that.textEditor.doc.getRange(that.currentToken.state.startPos,
                                    that.currentToken.state.endPos);

                            that.activePlugin = plugin;
                            that.pluginManager.activate(plugin, that.currentToken);

                            that.showPlugin();
                        });

                        that.textEditor.addWidget(that.textEditor.getCursor(), that.$widget[0]);
                    }
                }
            });

            that.pluginManager.addEventListener('close', function () {
                that.$pluginWrapper.detach();
            });

            that.pluginManager.addEventListener('save', function (plugin) {
                // plugin.data.content is the updated value
                //
                that.textEditor.replaceRange(
                    plugin.data.content,
                    that.currentToken.state.startPos,
                    that.currentToken.state.endPos
                );
            });

            that.pluginManager.addEventListener('toggle-plugin', function (plugin) {
                that.activePlugin = plugin;
                that.showPlugin();
            });

            that.preview.addEventListener('field-select', function (field, column) {
                if (that.editable) {
                    if (that.editable === column) {
                        return;
                    }

                    that.editable.$el.removeClass('active');
                    that.editable.history = that.textEditor.getHistory();
                    that.editable = null;
                }

                if (field.type === 'textarea' && column) {
                    that.editable = column;
                    column.$el.addClass('active');

                    that.preview.scrollSync(that.editable.$el, 1);

                    that.textEditor.operation(function () {
                        var classList = that.textEditor.getWrapperElement().classList;

                        that.textEditor.setValue(column.data);
                        that.textEditor.clearHistory();

                        if (that.editable.history) {
                            that.textEditor.setHistory(that.editable.history);
                        }

                        that.textEditor.setOption('readOnly', false);
                        that.textEditor.execCommand('selectAll');
                        that.textEditor.focus();

                        // add and remove class 'activated'
                        // to trigger css animation keyframes.
                        classList.add('activated');
                        setTimeout(function () {
                            classList.remove('activated');
                        }, 2000);

                        return;
                    });
                } else {
                    that.emptyTextEditor();
                }
            });

            that.preview.addEventListener('blur', function () {
                if (that.editable) {
                    that.editable.$el.removeClass('active');
                    that.editable = null;
                }
                that.emptyTextEditor();
            });

            that.preview.addEventListener('column-add', function (column) {
                column.set(that.parser.parse(column.data));
            });

            that.preview.setLayoutBuilderConfiguration(that.layoutBuilderConfiguration);
            that.preview.createFromForm(that.$form);

            Content.init(that.preview.$el[0]);

            (function () {
                var $possibleErrors = that.preview.$el.find('.has-error');
                if ($possibleErrors.length) {
                    that.preview.$el.parent().animate({
                        scrollTop: $possibleErrors.first().position().top
                    });
                }
            }());

            that.$submit.click(function () {
                if (that.preview.submit) {

                    $(window).unbind('beforeunload');
                    $(that.preview.submit).click();
                }
            });
        };

        Editor.prototype.initKeyshortCuts = function (shortcuts) {
            var that = this;
            shortcuts.addEventListener('cmd+shift+right', function (e) {
                e.stopPropagation();
                that.preview.focusNextColumn();
            });

            shortcuts.addEventListener('cmd+shift+left', function (e) {
                e.stopPropagation();
                that.preview.focusPreviousColumn();
            });

            shortcuts.addEventListener('cmd+shift+up', function (e) {
                e.stopPropagation();
                that.preview.focusPreviousRow();
            });

            shortcuts.addEventListener('cmd+shift+down', function (e) {
                e.stopPropagation();
                that.preview.focusNextRow();
            });

            // send all shortcuts
            // to texteditor helpers,
            // if there is an active editable
            shortcuts.addEventListener('always', function (shortcut, e) {
                if (that.editable) {
                    e.stopPropagation();
                    _.each(that.helpers, function (helper) {
                        if (helper.trigger) {
                            helper.trigger(shortcut, e);
                        }
                    });
                }
            });
        };

        Editor.prototype.addHelper = function (helper, id) {
            var $group = $('#editor-plugin-group-' + id);
            if (!$group.length) {
                $group = $('<div>')
                    .addClass('btn-group').attr({id: 'editor-plugin-group-' + id});
                this.$helpers.append($group);
            }
            $group.append(helper.$el);
            this.helpers.push(helper);
        };

        Editor.prototype.addPlugin = function (plugin) {
            this.plugins.push(plugin);
            return this;
        };

        Editor.prototype.showPlugin = function () {
            if (this.activePlugin) {
                this.$pluginWrapper
                    .append(this.activePlugin.$el)
                    .appendTo($body);

                this.activePlugin.render();
            }
        };

        Editor.prototype.resize = function () {
            if (this.textEditor) {
                this.textEditor.setSize($window.width() / 2, $window.height() - 58);
            }
            return this;
        };

        Editor.prototype.emptyTextEditor = function () {
            var that = this;

            that.textEditor.operation(function () {
                that.textEditor.setValue('');
                that.textEditor.setOption('readOnly', true);
            });
        };

        return Editor;
    });

require([
    'jquery',
    'underscore',
    'common',
    'translator',
    'ATHENE2-EDITOR',
    'codemirror',
    'parser',
    'preview',
    'showdown',
    'layout_builder_configuration',
    'texteditor_helper',
    'texteditor_plugin_manager',
    'texteditor_plugin',
    'system_notification',
    'showdown_table',
    'showdown_spoiler',
    'showdown_spoiler_prepare',
    'showdown_htmlstrip',
    'showdown_latex',
    'showdown_latex_output',
    'showdown_injections',
    'showdown_atusername',
    'showdown_strikethrough',
    'showdown_code_prepare',
    'showdown_code_output',
    'texteditor_plugin_image',
    'texteditor_plugin_wiris',
    'texteditor_plugin_injection',
    'texteditor_plugin_default_injection',
    'texteditor_plugin_geogebra_injection',
    'deployggb',
    'texteditor_plugin_geogebratube_injection'
],
    function (
        $, _, Common, t, Editor, CodeMirror, Parser, Preview, Showdown, LayoutBuilderConfiguration, TextEditorHelper,
        PluginManager, EditorPlugin, SystemNotification
        ) {
        "use strict";

        if (typeof MathJax !== 'undefined') {
            MathJax.Hub.Config({
                displayAlign: 'left',
                extensions: ['tex2jax.js', 'fast-preview.js'],
                jax: ['input/TeX', 'output/SVG', 'output/CommonHTML'],
                skipStartupTypeset: true,
                tex2jax: {
                    inlineMath: [
                        ['%%', '%%']
                    ],
                    displayMath: [
                        ["$$", "$$"]
                    ],
                },
                'HTML-CSS': {
                    scale: 100,
                    linebreaks: {
                        automatic: true
                    },
                    preferredFont: 'STIX'
                },
                SVG: {
                    linebreaks: {
                        automatic: true
                    },
                    font: 'STIX-Web'
                },
                showProcessingMessages: false,
                TeX: {
                    extensions: ['mhchem.js']
                }
            });
        }

        $(function () {
            // Set language
            t.config({
                language: $('html').attr('lang') || 'de'
            });

            // Setup a filter for comparing mathInline spans.
            $.fn.quickdiff("filter", "mathSpanInline",
                function (node) {
                    return (node.nodeName === "SPAN" && $(node).hasClass("mathInline"));
                },
                function (a, b) {
                    var aHTML = $.trim($("script", a).text()),
                        bHTML = $.trim($(b).text());
                    return ("%%" + aHTML + "%%") !== bHTML;
                });

            // Setup a filter for comparing math spans.
            $.fn.quickdiff("filter", "mathSpan",
                function (node) {
                    return (node.nodeName === "SPAN" && $(node).hasClass("math"));
                },
                function (a, b) {
                    var aHTML = $.trim($("script", a).text()),
                        bHTML = $.trim($(b).text());
                    return ("$$" + aHTML + "$$") !== bHTML;
                });

            $.fn.quickdiff("attributes", {
                "td": ["align"],
                "th": ["align"],
                "img": ["src", "alt", "title"],
                "a": ["href", "title"]
            });

            function init() {
                var editor,
                    textEditor,
                    layoutBuilderConfiguration = new LayoutBuilderConfiguration(),
                    parser = new Parser(),
                    converter = new Showdown.converter({
                        extensions: [
                            'codeprepare',
                            'injections',
                            'table',
                            'htmlstrip',
                            'latex',
                            'atusername',
                            'strikethrough',
                            'spoiler',
                            'spoilerprepare',
                            'latexoutput',
                            'codeoutput'
                        ]
                    }),
                    pluginManager = new PluginManager();

                // converter.config.math = true;
                // converter.config.stripHTML = true;
                // converter.config.tables = true;

                parser.setConverter(converter, 'makeHtml');

                layoutBuilderConfiguration
                    .addLayout([24])
                    .addLayout([12, 12])
                    .addLayout([9, 15])
                    .addLayout([6, 18])

                    .addLayout([6, 4, 14])
                    .addLayout([9, 4, 11])
                    .addLayout([12, 4, 8])

                    .addLayout([16, 8])
                    .addLayout([8, 8, 8])
                    .addLayout([6, 6, 12])
                    .addLayout([12, 6, 6])
                    .addLayout([6, 12, 6])
                    .addLayout([6, 6, 6, 6]);

                pluginManager
                    .addPlugin(new EditorPlugin.Image({
                        dataType: 'json',
                        type: 'post',
                        url: '/attachment/upload',
                        paramName: 'attachment[file]',
                        loadImageMaxFileSize: 8000000,
                        maxNumberOfFiles: 1
                    }))
                    .addPlugin(new EditorPlugin.Wiris())
                    .addPlugin((function () {
                        // Inline Math Plugin
                        var plugin = new EditorPlugin.Wiris();
                        plugin.state = 'inline-math';
                        plugin.wrap = '%%';
                        return plugin;
                    }()))
                    .addPlugin(new EditorPlugin.DefaultInjection())
                    .addPlugin(new EditorPlugin.GeogebraInjection({
                        dataType: 'json',
                        type: 'post',
                        url: '/attachment/upload',
                        loadImageMaxFileSize: 8000000,
                        maxNumberOfFiles: 1
                    }))
                    .addPlugin(new EditorPlugin.GeogebraTubeInjection())
                    .addPlugin(new EditorPlugin.Injection());

                textEditor = new CodeMirror($('#main .editor-main-inner')[0], {
                    lineNumbers: true,
                    styleActiveLine: true,
                    matchBrackets: true,
                    lineWrapping: true,
                    readOnly: 'nocursor'
                });

                editor = editor || new Editor({
                    $form: $('form').first(),
                    $helpers: $('#editor-helpers'),
                    $submit: $('#editor-actions .btn-success'),
                    parser: parser,
                    layoutBuilderConfiguration: layoutBuilderConfiguration,
                    textEditor: textEditor,
                    preview: new Preview({
                        $el: $('#preview .editor-main-inner')
                    }),
                    pluginManager: pluginManager
                });

                //editor.addHelper(new TextEditorHelper.Undo(textEditor), '3');
                //editor.addHelper(new TextEditorHelper.Redo(textEditor), '3');

                editor.addHelper(new TextEditorHelper.Bold(textEditor), '1');
                editor.addHelper(new TextEditorHelper.Italic(textEditor), '1');
                editor.addHelper(new TextEditorHelper.Strike(textEditor), '1');
                editor.addHelper(new TextEditorHelper.List(textEditor), '1');

                editor.addHelper(new TextEditorHelper.Link(textEditor), '2');
                editor.addHelper(new TextEditorHelper.Injection(textEditor), '2');
                editor.addHelper(new TextEditorHelper.Image(textEditor), '2');
                editor.addHelper(new TextEditorHelper.Formula(textEditor), '2');
                editor.addHelper(new TextEditorHelper.Spoiler(textEditor), '2');

                editor.addHelper(new TextEditorHelper.HidePlugins(textEditor), '3');

                editor.addHelper(new TextEditorHelper.Fullscreen());

                editor.initialize();

                $('.helper').tooltip({
                    container: 'body'
                });

                window.editor = editor;
                Common.addEventListener('generic error', function () {
                    SystemNotification.error();
                });

                $(window).bind('beforeunload', function () {
                    return t('Are you sure you want to leave this page? All of your unsaved changes will be lost!');
                });
            }

            init($('body'));
        });
    });
