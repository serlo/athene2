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
        dist: 'build',
        tmp: 'tmp'
    };

    grunt.initConfig({
        serlo: config,
        watch: {
            compass: {
                files: ['<%= serlo.app %>/styles/{,*/}*.{scss,sass}'],
                tasks: ['compass:server', 'autoprefixer', 'clean:dist', 'copy:dist']
            },
            styles: {
                files: ['<%= serlo.app %>/styles/{,*/}*.css'],
                tasks: ['copy:styles', 'autoprefixer', 'clean:dist', 'copy:dist']
            },
            jsLang: {
                files: ['<%= serlo.app %>/lang/*'],
                tasks: ['i18n', 'clean:dist', 'copy:dist']
            },
            scripts: {
                files: ['<%= serlo.app %>/scripts/{,*/}*.js'],
                tasks: ['jshint', 'copy:requirejs', 'requirejs:production', 'clean:dist', 'copy:dist']
            },
            images: {
                files: ['<%= serlo.app %>/images/{,*/}*.{png,jpg,jpeg}'],
                tasks: ['imagemin', 'clean:dist', 'copy:dist']
            },
            fonts: {
                files: ['<%= serlo.app %>/styles/fonts/*'],
                tasks: ['copy:tmp', 'clean:dist', 'copy:dist']
            }
        },
        clean: {
            tmp: {
                files: [{
                    dot: true,
                    src: [
                        '<%= serlo.tmp %>/*',
                        '!<%= serlo.tmp %>/.git*'
                    ]
                }]
            },
            dist: {
                files: [{
                    dot: true,
                    src: [
                        '<%= serlo.dist %>/*',
                        '!<%= serlo.dist %>/.git*'
                    ]
                }]
            },
            server: '<%= serlo.tmp %>'
        },
        jshint: {
            options: {
                jshintrc: '.jshintrc',
                ignores: [
                    '<%= serlo.app %>/scripts/thirdparty/{,*/}*.js',
                    '<%= serlo.app %>/scripts/modules/serlo_i18n.js',
                    '<%= serlo.app %>/scripts/libs/polyfills.js'
                ]
            },
            all: [
                '<%= serlo.app %>/scripts/{,*/}*.js'
            ]
        },
        compass: {
            options: {
                sassDir: '<%= serlo.app %>/styles',
                cssDir: '<%= serlo.tmp %>/styles',
                generatedImagesDir: '<%= serlo.tmp %>/images/generated',
                imagesDir: '<%= serlo.app %>/images',
                javascriptsDir: '<%= serlo.app %>/scripts',
                fontsDir: '<%= serlo.app %>/styles/fonts',
                importPath: '<%= serlo.app %>/bower_components',
                httpImagesPath: '/images',
                httpGeneratedImagesPath: '/images/generated',
                httpFontsPath: '/styles/fonts',
                relativeAssets: false
            },
            tmp: {
                options: {
                    generatedImagesDir: '<%= serlo.tmp %>/images/generated'
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
            tmp: {
                files: [{
                    expand: true,
                    cwd: '<%= serlo.tmp %>/styles/',
                    src: '{,*/}*.css',
                    dest: '<%= serlo.tmp %>/styles/'
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
            tmp: {
                options: {
                    banner: '/**\n' +
                            ' * \n' +
                            ' * Athene2 - Advanced Learning Resources Manager \n' +
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
                //     '<%= serlo.tmp %>/scripts/main.js': '<%= serlo.tmp %>/scripts/main.js'
                // }
                files: [{
                    '<%= serlo.tmp %>/scripts/main.js': '<%= serlo.tmp %>/scripts/main.js',
                    '<%= serlo.tmp %>/bower_components/requirejs/require.js': '<%= serlo.tmp %>/bower_components/requirejs/require.js'
                }]
            }
        },
        imagemin: {
            tmp: {
                files: [{
                    expand: true,
                    cwd: '<%= serlo.app %>/images',
                    src: '{,*/}*.{png,jpg,jpeg}',
                    dest: '<%= serlo.tmp %>/images'
                }]
            }
        },
        svgmin: {
            tmp: {
                files: [{
                    expand: true,
                    cwd: '<%= serlo.app %>/images',
                    src: '{,*/}*.svg',
                    dest: '<%= serlo.tmp %>/images'
                }]
            }
        },
        cssmin: {
            minify: {
                expand: true,
                cwd: '<%= serlo.tmp %>/styles/',
                src: ['*.css', '!*.min.css'],
                dest: '<%= serlo.tmp %>/styles/',
                ext: '.css'
            }
        },
        // Put files not handled in other tasks here
        copy: {
            tmp: {
                files: [{
                    expand: true,
                    dot: true,
                    cwd: '<%= serlo.app %>',
                    dest: '<%= serlo.tmp %>',
                    src: [
                        '.htaccess',
                        'styles/fonts/{,*/}*.*',
                        'bower_components/jquery/jquery.min.map'
                    ]
                }]
            },
            dist: {
                files: [{
                    expand: true,
                    dot: true,
                    cwd: '<%= serlo.tmp %>',
                    dest: '<%= serlo.dist %>',
                    src: [
                        '**'
                    ]
                }]
            },
            styles: {
                expand: true,
                dot: true,
                cwd: '<%= serlo.app %>/styles',
                dest: '<%= serlo.tmp %>/styles/',
                src: '{,*/}*.css'
            },
            requirejs: {
                expand: true,
                dot: true,
                cwd: '<%= serlo.app %>/bower_components/requirejs',
                dest: '<%= serlo.tmp %>/bower_components/requirejs',
                src: 'require.js'
            },
            modernizr: {
                expand: true,
                dot: true,
                cwd: '<%= serlo.app %>/bower_components/modernizr',
                dest: '<%= serlo.tmp %>/bower_components/modernizr',
                src: 'modernizr.js'
            }
        },
        i18n: {
            src: ['<%= serlo.app %>/lang/*.json'],
            dest: '<%= serlo.app %>/scripts/modules/serlo_i18n.js'
        },
        modernizr: {
            devFile: '<%= serlo.app %>/bower_components/modernizr/modernizr.js',
            outputFile: '<%= serlo.tmp %>/bower_components/modernizr/modernizr.js',
            files: [
                '<%= serlo.tmp %>/scripts/{,*/}*.js',
                '<%= serlo.tmp %>/styles/{,*/}*.css',
                '!<%= serlo.tmp %>/scripts/vendor/*'
            ],
            "extensibility" : {
                "prefixed" : true
            },
            uglify: true
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
            tmp: [
                'compass',
                'copy:styles',
                'copy:requirejs',
                'svgmin'
            ],
            dist: [
                'copy:dist'
            ]
        },
        requirejs: {
            production: {
                options: {
                    baseUrl: "<%= serlo.app %>/scripts",
                    mainConfigFile: "source/scripts/main.js",
                    out: "<%= serlo.tmp %>/scripts/main.js",
                    preserveLicenseComments: false,
                    optimize: 'none'
                }
            },
            testing: {
                options: {
                    name: 'ATHENE2-TEST',
                    baseUrl: "<%= serlo.app %>/tests/modules",
                    mainConfigFile: "source/tests/modules/specRunner.js",
                    out: "<%= serlo.tmp %>/scripts/main.js",
                    preserveLicenseComments: false,
                    optimize: 'none'
                }
            }
        },
        "language-update": {
            src: [
                '<%= serlo.app %>/scripts/{,*/}*.js'
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
                    '<%= serlo.tmp %>/styles/main.css'
                ],
                dest: '<%= serlo.tmp %>/styles/main.css'
            }
        }
    });

    grunt.registerTask('dev', function (target) {
        if (target === 'tmp') {
            return grunt.task.run(['build']);
        }

        grunt.task.run([
            'clean:server',
            'concurrent:server',
            'autoprefixer',
            'copy:requirejs',
            'i18n',
            'requirejs:production',
            'copy:tmp',
            'copy:modernizr',
            'clean:dist',
            'copy:dist',
            'watch'
        ]);
    });

    grunt.registerTask('build', [
        'clean:tmp',
        'concurrent:tmp',
        'autoprefixer',
        'copy:tmp',
        'i18n',
        'cssmin',
        'imagemin',
        'requirejs:production',
        'modernizr',
        'uglify',
        'clean:dist',
        'copy:dist',
        'clean:tmp'
    ]);

    grunt.registerTask('default', [
        'jshint',
        'build'
    ]);

    grunt.registerTask('test', [
        'requirejs:testing',
        'concat:test'
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
