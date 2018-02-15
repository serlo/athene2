'use strict';

// # Globbing
// for performance reasons we're only matching one level down:
// 'test/spec/{,*/}*.js'
// use this if you want to recursively match all subfolders:
// 'test/spec/**/*.js'

module.exports = function (grunt) {
    // show elapsed time at the end
    require('time-grunt')(grunt);
    // load all grunt tasks
    require('load-grunt-tasks')(grunt);

    // configurable paths
    var config = {
        app: 'source',
        dist: 'build'
    };

    grunt.initConfig({
        serlo: config,
        watch: {
            compass: {
                files: ['<%= serlo.app %>/styles/{,*/}*.{scss,sass}'],
                tasks: ['compass:server', 'autoprefixer']
            },
            styles: {
                files: ['<%= serlo.app %>/styles/{,*/}*.css'],
                tasks: ['copy:styles', 'autoprefixer']
            },
            jsLang: {
                files: ['<%= serlo.app %>/lang/*'],
                tasks: ['i18n']
            },
            scripts: {
                files: ['<%= serlo.app %>/scripts/{,*/,**/}*.{js,html}'],
                tasks: ['jshint', 'copy:requirejs', 'requirejs:production']
            },
            images: {
                files: ['<%= serlo.app %>/images/{,*/}*.{png,jpg,jpeg}'],
                tasks: ['imagemin']
            },
            fonts: {
                files: ['<%= serlo.app %>/styles/fonts/*'],
                tasks: ['copy:dist']
            }
        },
        clean: {
            dist: {
                files: [{
                    dot: true,
                    src: [
                        '<%= serlo.dist %>/*',
                        '!<%= serlo.dist %>/.git*'
                    ]
                }]
            },
            server: '<%= serlo.dist %>'
        },
        jshint: {
            options: {
                jshintrc: '.jshintrc',
                ignores: [
                    '<%= serlo.app %>/scripts/thirdparty/{,*/}*.js',
                    '<%= serlo.app %>/scripts/modules/serlo_i18n.js',
                    '<%= serlo.app %>/scripts/libs/polyfills.js',
                    '<%= serlo.app %>/scripts/libs/markdown.js',
                    '<%= serlo.app %>/scripts/codemirror/codemirror.js',
                    '<%= serlo.app %>/scripts/libs/showdown.js',
                    '<%= serlo.app %>/scripts/libs/quickdiff.js',
                    '<%= serlo.app %>/scripts/editor/plugins/wiris/wiris.js'
                ]
            },
            all: [
                '<%= serlo.app %>/scripts/{,*/}*.js',
                '<%= serlo.app %>/editor/scripts/{,*/}*.js'
            ]
        },
        compass: {
            options: {
                sassDir: '<%= serlo.app %>/styles',
                cssDir: '<%= serlo.dist %>/styles',
                generatedImagesDir: '<%= serlo.dist %>/images/generated',
                imagesDir: '<%= serlo.app %>/images',
                javascriptsDir: '<%= serlo.app %>/scripts',
                fontsDir: '<%= serlo.app %>/styles/fonts',
                importPath: '<%= serlo.app %>/bower_components',
                httpImagesPath: '/images',
                httpGeneratedImagesPath: '/images/generated',
                httpFontsPath: '/styles/fonts',
                relativeAssets: false
            },
            dist: {
                options: {
                    generatedImagesDir: '<%= serlo.dist %>/images/generated'
                }
            },
            server: {
                options: {
                    debugInfo: true
                }
            }
        },
        autoprefixer: {
            options: {
                browsers: ['last 2 version']
            },
            dist: {
                files: [{
                    expand: true,
                    cwd: '<%= serlo.dist %>/styles/',
                    src: '{,*/}*.css',
                    dest: '<%= serlo.dist %>/styles/'
                }]
            }
        },
        'bower-install': {
            app: {
                html: '<%= serlo.app %>/index.html',
                ignorePath: '<%= serlo.app %>/'
            }
        },
        uglify: {
            dist: {
                options: {
                    banner: '/**\n' +
                    ' * \n' +
                    ' * Athene2 Editor - v0.2.4 \n' +
                    ' *\n' +
                    ' * @license LGPL-3.0\n' +
                    ' * @license http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0\n' +
                    ' * @link https://github.com/serlo-org/athene2 for the canonical source repository\n' +
                    ' * @copyright Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)\n' +
                    ' */\n',
                    output: {
                        beautify: false
                    },
                    compress: {
                        sequences: true,
                        global_defs: {
                            DEBUG: true
                        }
                    },
                    warnings: true,
                    mangle: true
                },
                // files: {
                //     '<%= serlo.dist %>/scripts/main.js': '<%= serlo.dist %>/scripts/main.js'
                // }
                files: [{
                    '<%= serlo.dist %>/scripts/editor.js': '<%= serlo.dist %>/scripts/editor.js',
                    '<%= serlo.dist %>/bower_components/requirejs/require.js': '<%= serlo.dist %>/bower_components/requirejs/require.js'
                }]
            }
        },
        imagemin: {
            dist: {
                files: [{
                    expand: true,
                    cwd: '<%= serlo.app %>/images',
                    src: '{,*/}*.{png,jpg,jpeg}',
                    dest: '<%= serlo.dist %>/images'
                }]
            }
        },
        svgmin: {
            dist: {
                files: [{
                    expand: true,
                    cwd: '<%= serlo.app %>/images',
                    src: '{,*/}*.svg',
                    dest: '<%= serlo.dist %>/images'
                }]
            }
        },
        cssmin: {
            minify: {
                expand: true,
                cwd: '<%= serlo.dist %>/styles/',
                src: ['*.css', '!*.min.css'],
                dest: '<%= serlo.dist %>/styles/',
                ext: '.css'
            }
        },
        // Put files not handled in other tasks here
        copy: {
            dist: {
                files: [{
                    expand: true,
                    dot: true,
                    cwd: '<%= serlo.app %>',
                    dest: '<%= serlo.dist %>',
                    src: [
                        '.htaccess',
                        'styles/fonts/{,*/}*.*',
                        'bower_components/jquery/jquery.min.map'
                    ]
                }]
            },
            styles: {
                expand: true,
                dot: true,
                cwd: '<%= serlo.app %>/styles',
                dest: '<%= serlo.dist %>/styles/',
                src: '{,*/}*.css'
            },
            requirejs: {
                expand: true,
                dot: true,
                cwd: '<%= serlo.app %>/bower_components/requirejs',
                dest: '<%= serlo.dist %>/bower_components/requirejs',
                src: 'require.js'
            }
        },
        i18n: {
            src: ['<%= serlo.app %>/lang/*.json'],
            dest: '<%= serlo.app %>/scripts/modules/serlo_i18n.js'
        },
        concurrent: {
            server: [
                'compass',
                'copy:styles',
                'copy:requirejs'
            ],
            test: [
                'copy:styles',
                'copy:requirejs'
            ],
            dist: [
                'compass',
                'copy:styles',
                'copy:requirejs',
                'svgmin'
            ]
        },
        requirejs: {
            production: {
                options: {
                    baseUrl: "<%= serlo.app %>/scripts",
                    mainConfigFile: "source/scripts/main.js",
                    out: "<%= serlo.dist %>/scripts/editor.js",
                    preserveLicenseComments: false,
                    optimize: 'none',
                    wrap: true,
                    inlineText: true,
                    stubModules: ['test'],
                    paths: {
                        'text': '../bower_components/text/text'
                    }
                }
            },
            testing: {
                options: {
                    name: 'ATHENE2-TEST',
                    baseUrl: "<%= serlo.app %>/tests/modules",
                    mainConfigFile: "source/tests/modules/specRunner.js",
                    out: "<%= serlo.dist %>/scripts/editor.js",
                    preserveLicenseComments: false,
                    optimize: 'none'
                }
            }
        },
        "language-update": {
            src: [
                '<%= serlo.app %>/scripts/{,*/,**/}*.js'
            ],
            langSrc: [
                '<%= serlo.app %>/lang/*.json'
            ],
            dest: '<%= serlo.app %>/lang-processed'
        },
        concat: {
            test: {
                src: [
                    '<%= serlo.app %>/bower_components/jasmine/lib/jasmine-core/jasmine.css',
                    '<%= serlo.dist %>/styles/main.css'
                ],
                dest: '<%= serlo.dist %>/styles/main.css'
            }
        },
        connect: {
            server: {
                options: {
                    port: 9001,
                    base: '.',
                    open: true
                }
            }
        }
    });

    grunt.registerTask('dev', function (target) {
        if (target === 'dist') {
            return grunt.task.run(['build']);
        }

        grunt.task.run([
            'clean:server',
            'concurrent:server',
            'autoprefixer',
            'copy:requirejs',
            'i18n',
            'requirejs:production',
            'copy:dist',
            'connect',
            'watch'
        ]);
    });

    grunt.registerTask('build', [
        'clean:dist',
        'concurrent:dist',
        'autoprefixer',
        'copy:dist',
        'i18n',
        'cssmin',
        'imagemin',
        'requirejs:production',
        'uglify:dist'
    ]);

    grunt.registerTask('default', [
        'jshint',
        'build'
    ]);

    grunt.registerTask('i18n', 'Creates an AMD module based on language files', function () {
        var data = grunt.config('i18n'),
            files = grunt.file.expand(data.src),
            output = '/**\n * Dont edit this file!\n' +
                ' * This module generates itself from lang.js files!\n' +
                ' * Instead edit the language files in /lang/\n' +
                ' **/\n\n' +
                '/*global define*/\n' +
                'define(function () {\n' +
                '"use strict";\n' +
                'var i18n = {};\n';

        files.forEach(function (f) {
            var contents = grunt.file.read(f),
                langName = f.split('/').pop().replace('.json', '');

            output += '\ni18n.' + langName + ' = ' + contents + ';\n';
        });

        output += '\nreturn i18n;\n' +
            '});';

        grunt.file.write(data.dest, output);
    });

    grunt.registerMultiTask('language-update', 'Fetches translation strings from source files', function () {
        grunt.file.defaultEncoding = 'utf8';
        var data = grunt.config('language-update'),
            files = grunt.file.expand(data.src),
            languages = grunt.file.expand(data.langSrc),
            searchFunction = new RegExp(/(\(|^|[\s\n])t\(["']([^")]|[^')])*\)/g),
            filterString = new RegExp(/(["]([^"])*["])|([']([^'])*['])/),
            strings = [];

        files.forEach(function (f) {
            var contents = grunt.file.read(f);

            contents.replace(searchFunction, function (match) {
                match.replace(filterString, function (string) {
                    // string = string.split('');
                    // string.pop().shift();
                    string = string.substr(1);
                    string = string.substring(0, string.length - 1);

                    if (strings.indexOf(string) < 0) {
                        strings.push(string);
                    }
                });
            });
            // grunt.file.write(p, header + sep + contents + sep + footer);
            // grunt.log.writeln('File "' + p + '" created.');
        });

        languages.forEach(function (lang) {
            var contents = grunt.file.readJSON(lang);

            strings.forEach(function (string) {
                if (!contents[string]) {
                    contents[string] = "";
                }
            });

            contents = JSON.stringify(contents);

            contents = contents.replace(/\{/g, "{\n    ");
            contents = contents.replace(/","/g, "\",\n    \"");
            contents = contents.replace(/":"/g, "\" : \"");
            contents = contents.replace(/\}/g, "\n}");

            grunt.file.write(lang, contents);
        });
    });
};
