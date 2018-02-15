/* Athene2 Editor
 * Serverside Markdown Parser
 *
 * Uses a slightly modified version of showdown.
 *
 * Offers a `render` method via dNode.
 *
 */

var dnode = require('dnode'),
    Showdown = require('showdown'),
    cheerio = require('cheerio'),
    async = require('async'),
    vm = require('vm'),
    HtmlEntities = require('html-entities').AllHtmlEntities,
    htmlEntities = new HtmlEntities(),
    converter,
    waitForMathJaxTime = process.env.MATHJAX_TIMEOUT * 1000 || 10 * 1000,
    server,
    port = 7070,
    host = '127.0.0.1';

// Load custom extensions
Showdown.extensions.serloinjections = require('../source/scripts/editor/showdown/extensions/injections');
Showdown.extensions.serlotable = require('../source/scripts/editor/showdown/extensions/table');
Showdown.extensions.serlospoilerprepare = require('../source/scripts/editor/showdown/extensions/spoiler_prepare');
Showdown.extensions.serlospoiler = require('../source/scripts/editor/showdown/extensions/spoiler');
Showdown.extensions.serlolatex = require('../source/scripts/editor/showdown/extensions/latex');
Showdown.extensions.serlolatexoutput = require('../source/scripts/editor/showdown/extensions/latex_output');
Showdown.extensions.serlohtmlstrip = require('../source/scripts/editor/showdown/extensions/html_strip');
Showdown.extensions.serloatusername = require('../source/scripts/editor/showdown/extensions/at_username');
Showdown.extensions.serlostrikethrough = require('../source/scripts/editor/showdown/extensions/strike_through');
Showdown.extensions.serlocodeprepare = require('../source/scripts/editor/showdown/extensions/serlo_code_prepare');
Showdown.extensions.serlocodeoutput = require('../source/scripts/editor/showdown/extensions/serlo_code_output');

converter = new Showdown.converter({
    extensions: [
        'serlocodeprepare',
        'serloinjections',
        'serloatusername',
        'serlostrikethrough',
        'serlotable',
        'serlospoilerprepare',
        'serlospoiler',
        'serlohtmlstrip',
        'serlolatex',
        'serlolatexoutput',
        'serlocodeoutput'
    ]
});

// converter.config.math = true;
// converter.config.stripHTML = true;

// **render**
// @param {String} input Json string,
// containing Serlo Flavored Markdown (sfm)
// structured for layout.
// @param {Function} callback
function render(input, callback) {
    var output,
        data,
        row,
        column,
        i, l, j, lj, mjt = {timeout: null};

    // callback(output, Exception, ErrorMessage);
    if (input === undefined) {
        callback('', 'InvalidArgumentException', 'No input given');
        return;
    }

    if (input === '') {
        callback('');
    } else {

        // parse input to object
        try {
            input = input.trim().replace(/&quot;/g, '"');
            data = JSON.parse(input);
        } catch (e) {
            callback('', 'InvalidArgumentException', 'No valid json string given: ' + input);
            return;
        }

        output = '';

        for (i = 0, l = data.length; i < l; i++) {
            row = data[i];
            output += '<div class="r">';
            for (j = 0, lj = row.length; j < lj; j++
                ) {
                column = row[j];
                output += '<div class="c' + column.col + '">';
                output += converter.makeHtml(column.content);
                output += '</div>';
            }
            output += '</div>';
        }

        callback(output);

        /*
        mjt.timeout = setTimeout(function () {
            console.log('MathJax: had to fall back.');
            mjt.timeout = null;
            callback(output);
        }, waitForMathJaxTime);

        var sandbox = {
            output: output,
            cheerio: cheerio,
            callback: callback,
            mjt: mjt,
            gc: global.gc(),
            console: console,
            handleMathJax: function (document, cb, mjt) {
                var M = require('./lib/mj-single-concurrent');
                delete require.cache[require.resolve('./lib/mj-single-concurrent')];
                var widthBreakpoints = {
                        c24: 90, c18: 70, c16: 60, c15: 55,
                        c14: 52, c12: 45, c11: 41, c9: 30,
                        c8: 27, c6: 20, c4: 15},
                    params = {
                        format: 'TeX',
                        math: '',
                        svg: true,
                        mml: false,
                        png: false,
                        speakText: false,
                        speakRuleset: 'mathspeak',
                        speakStyle: 'default',
                        width: 100000000,
                        linebreaks: true
                    },
                    asyncTasks = [],
                    mjAPI = new M(),
                    pushRenderTask = function () {
                        var self = $(this);
                        asyncTasks.push(function (pushCallback) {
                            var mathText = self.html();
                            params.width =
                                widthBreakpoints[self.closest('.c24, .c18, .c16, .c15, .c14, .c12, .c11, .c9, .c8, .c6, .c4').attr('class')];

                            mathText = htmlEntities.decode(mathText);
                            if (mathText.substring(0, 2) === '$$' && mathText.substring(mathText.length - 2,
                                mathText.length) === '$$') {
                                params.format = 'TeX';
                                params.math = mathText.substring(2, mathText.length - 2);
                            } else if (mathText.substring(0, 2) === '%%' && mathText.substring(mathText.length - 2,
                                mathText.length) === '%%') {
                                params.format = 'inline-TeX';
                                params.math = mathText.substring(2, mathText.length - 2);
                            } else {
                                pushCallback();
                                return;
                            }

                            try {
                                mjAPI.typeset(params, function (result) {
                                    self.html(result.svg);
                                    pushCallback();
                                });
                            } catch (exc) {
                                console.log('Fatal MathorJax error:', exc);
                                console.log('Tried to render: ', mathText);
                            }
                        });
                    };

                mjAPI.config({
                    MathJax: {
                        SVG: {
                            font: 'STIX-Web'
                        },
                        tex2jax: {
                            preview: ['[math]'],
                            processEscapes: true,
                            processClass: ['math'],
                            //inlineMath: [ ['\\%\\%','\\%\\%'], ['\\(','\\)'] ],
                            displayMath: [
                                ['$$', '$$'],
                                ['\\[', '\\]']
                            ],
                            skipTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code']
                        },
                        TeX: {
                            noUndefined: {disabled: true},
                            Macros: {
                                mbox: ['{\\text{#1}}', 1],
                                mb: ['{\\mathbf{#1}}', 1],
                                mc: ['{\\mathcal{#1}}', 1],
                                mi: ['{\\mathit{#1}}', 1],
                                mr: ['{\\mathrm{#1}}', 1],
                                ms: ['{\\mathsf{#1}}', 1],
                                mt: ['{\\mathtt{#1}}', 1]
                            }
                        }
                    }
                });
                mjAPI.start();

                try {
                    var $ = cheerio.load(document);
                } catch (exc) {
                    console.log('Error while building dom: ', exc);
                    cb(document);
                    return;
                }

                $('.math, .mathInline').each(pushRenderTask);
                if (asyncTasks.length > 0) {
                    async.parallelLimit(asyncTasks, 800, function () {
                        if (mjt.timeout !== null) {
                            clearTimeout(mjt.timeout);
                            cb($.html());
                        }
                        mjAPI.stop();
                        gc();
                    });
                } else {
                    cb(document);
                }
            }
        };
        vm.createContext(sandbox);
        vm.runInNewContext('handleMathJax(output, callback, mjt);', sandbox, {timeout: waitForMathJaxTime});
        //vm.runInContext('console.log(output);handleMathjax(document, cb, mjt);', sandbox);*/
    }
}

server = dnode(function (remote, connection) {
    // Populate `render` function for
    // dnode clients.
    this.render = render;
});

server.listen(port);