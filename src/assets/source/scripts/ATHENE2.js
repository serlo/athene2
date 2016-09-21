/**
 *
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author  Julian Kempff (julian.kempff@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
/*global define, require, MathJax*/
define("ATHENE2", ['jquery', 'underscore', 'common', 'side_navigation', 'mobile_navigation', 'breadcrumbs', 'translator', 'side_element', 'content', 'system_notification',
                   'moment', 'ajax_overlay', 'tracking', 'toggle_action', 'modals', 'trigger', 'sortable_list',
                   'timeago', 'spoiler', 'injections', 'moment_de', 'affix', 'forum_select', 'slider', 'math_puzzle', 'input_challenge', 'single_choice', 'multiple_choice',
                   'magnific_popup', 'easing', 'nestable', 'historyjs', 'polyfills', 'datepicker', 'event_extensions', 'jasny', 'birdnest'
],
    function (
        $, _, Common, SideNavigation, MobileNavigation, Breadcrumbs, t, SideElement, Content, SystemNotification, moment, AjaxOverlay,
        Tracking
        ) {
        "use strict";
        var languageFromDOM,
            ajaxOverlay;

        function init($context) {
            languageFromDOM = $('html').attr('lang') ||  'de';
            // configure Translator to current language
            t.config({
                language: languageFromDOM
            });

            moment.lang(languageFromDOM);

            // 'resizeDelay' will be triggered if no `resize` event was triggered for 0.5s
            var cachedWidth = $(window).width();
            $(window).resize(_.debounce(function () {
                if (cachedWidth !== $(window).width()) {
                    $(this).trigger('resizeDelay');
                    cachedWidth = $(window).width();
                }
            }, 500));

            // create an system notification whenever Common.genericError is called
            Common.addEventListener('generic error', function () {
                SystemNotification.error();
            });
            // initialize contextuals whenever a new context is added

            if (!$('body').hasClass('serlo-home')) {
                $('#subject-nav').SerloAffix();
            }

            Content.add(function ($context) {
                // init sortable lists in context
                $('.sortable', $context).SortableList();
                // init timeago fields in context
                $('.timeago', $context).TimeAgo();
                // init dialogues in context
                $('.dialog', $context).SerloModals();
                // init datepicker
                $('.datepicker', $context).datepicker({
                    format: 'yyyy-mm-dd'
                });
                // init datepicker for dateranges
                $('.input-daterange', $context).datepicker({
                    format: 'yyyy-mm-dd'
                });
                // init spoilers
                $('.spoiler', $context).Spoiler();
                // init injections
                $('.injection', $context).Injections();
                // init edit controls
                $('[data-toggle]', $context).ToggleAction();
                // init triggers
                $('[data-trigger]', $context).TriggerAction();
                // forum select
                $('form[name="discussion"]', $context).ForumSelect();
                // Slider
                $('.carousel.slide.carousel-tabbed', $context).Slider();
                // profiles birdnest
                $('.nest-statistics', $context).renderNest();

                // Math puzzles
                $('.math-puzzle', $context).MathPuzzle();

                $('.text-exercise:has(.input-challenge-group)', $context).InputChallenge();
                $('.text-exercise:has(.single-choice-group)', $context).SingleChoice();
                $('.text-exercise:has(.multiple-choice-group)', $context).MultipleChoice();

                $('.r img', $context).each(function () {
                    var $that = $(this);
                    $that.magnificPopup({
                        type: 'image',
                        closeOnContentClick: true,
                        items: {
                            src: $that.attr('src')
                        },
                        image: {
                            verticalFit: true
                        },
                        disableOn: function () {
                            return $that.parents('a').length <= 0;
                        }
                    });
                });

                // NOTE: deactivated for now
                // init AjaxOverlay for /ref links
                // $('a[href^="/ref"]', $context).addClass('ajax-content');

                // init Mathjax
                MathJax.Hub.Queue(['Typeset', MathJax.Hub]);
            });

            // Tooltips opt in
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body'
            });

            Common.addEventListener('new context', function ($context) {
                Content.init($context);
            });

            // initialize the mobile navigation
            new MobileNavigation();
            // initialize breadcrumbs
            new Breadcrumbs();
            // initialize the side navigation
            new SideNavigation();
            // initialize the footer
            $('#footer-push').css('height', $('#footer').height());
            $('.wrap').css('margin-bottom', -$('#footer').height());

            $(window).bind('resizeDelay', function () {
                $('#footer-push').css('height', $('#footer').height());
                $('.wrap').css('margin-bottom', -$('#footer').height());
                MathJax.Hub.Queue(['Reprocess', MathJax.Hub]);
                $('.nest-statistics').renderNest();
            });

            // initialize the search
            // new Search();
            // initialize ajax overlay
            ajaxOverlay = new AjaxOverlay({
                on: {
                    contentOpened: function () {
                        Content.init(this.$el);
                    },
                    error: function (err) {
                        ajaxOverlay.shutDownAjaxContent();
                        SystemNotification.error(t("When asynchronously trying to load a ressource, I came across an error: %s", err.status + ' ' + err.statusText));
                    }
                }
            });

            // trigger new contextual
            Common.trigger('new context', $context);

            // Initialize the subject nav
            (function () {
                var opened = false,
                    $dropdown = $('#subject-nav .subject-dropdown');

                $dropdown.click(function (e) {
                    // stop bubbling
                    // so outside click
                    // wont close it
                    e.stopPropagation();
                });

                function closeDropdown() {
                    opened = false;
                    $dropdown.removeClass('open');
                    $context.unbind('click', closeDropdown);
                }

                $('.subject-dropdown-toggle', $dropdown).click(function (e) {
                    e.preventDefault();
                    opened = !opened;
                    $dropdown.toggleClass('open', opened);

                    if (opened) {
                        $context.click(closeDropdown);
                    }

                    return;
                });
            }());

            SideElement.init();

            new Tracking($context);
        }

        return {
            initialize: function ($context) {
                init($context);
            }
        };
    });

require(['jquery', 'ATHENE2', 'support'], function ($, App, Supporter) {
    "use strict";
    $(function () {
        App.initialize($('body'));
        Supporter.check();
    });
});
