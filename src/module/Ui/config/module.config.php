<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ui;

use Zend\Mvc\Application;
use ZfcRbac\Guard\GuardInterface;

return [
    'navigation'            => [
        'hydratables' => [
            'default'    => [
                'hydrators' => []
            ],
            'top-center' => [
                'hydrators' => []
            ],
            'top-right'  => [
                'hydrators' => []
            ]
        ]
    ],
    'zfctwig'               => [
        'helper_manager' => [
            'invokables' => [
                'partial' => 'Zend\View\Helper\Partial',
                'encrypt' => 'Ui\View\Helper\Encrypt',
            ],
            'factories'  => [
                'brand'    => __NAMESPACE__ . '\Factory\BrandHelperFactory',
                'tracking' => __NAMESPACE__ . '\Factory\TrackingFactory'
            ]
        ]
    ],
    'view_manager'          => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => [
            'athene2-editor' => __DIR__ . '/../templates/editor/layout.phtml',
            'layout/de/home' => __DIR__ . '/../templates/layout/de/serlo-home.phtml',
            'layout/en/home' => __DIR__ . '/../templates/layout/en/serlo-home.phtml',
            'layout/1-col'   => __DIR__ . '/../templates/layout/1-col.phtml',
            'layout/layout'  => __DIR__ . '/../templates/layout/2-col.phtml',
            'layout/3-col'   => __DIR__ . '/../templates/layout/3-col.phtml',
            'error/404'      => __DIR__ . '/../templates/error/404.phtml',
            'error/403'      => __DIR__ . '/../templates/error/403.phtml',
            'error/index'    => __DIR__ . '/../templates/error/index.phtml'
        ],
        'strategies'               => [
            'Zend\View\Strategy\JsonStrategy',
            'ViewFeedStrategy',
        ]
    ],
    'controller_plugins'    => [
        'factories' => [
            'brand' => __NAMESPACE__ . '\Factory\BrandPluginFactory'
        ]
    ],
    'view_helpers'          => [
        'factories'  => [
            'pageHeader'  => __NAMESPACE__ . '\Factory\PageHeaderFactory',
            'brand'       => __NAMESPACE__ . '\Factory\BrandHelperFactory',
            'twigPartial' => __NAMESPACE__ . '\Factory\TwigPartialFactory',
            'tracking'    => __NAMESPACE__ . '\Factory\TrackingFactory'
        ],
        'invokables' => [
            'encrypt'         => 'Ui\View\Helper\Encrypt',
            'timeago'         => 'Ui\View\Helper\Timeago',
            'registry'        => 'Ui\View\Helper\Registry',
            'currentLanguage' => 'Ui\View\Helper\ActiveLanguage',
            'toAlpha'         => 'Ui\View\Helper\ToAlpha',
            'diff'            => 'Ui\View\Helper\DiffHelper',
            'preview'         => 'Ui\View\Helper\PreviewHelper'
        ]
    ],
    'service_manager'       => [
        'factories'  => [
            'Ui\Renderer\PhpDebugRenderer'                     => __NAMESPACE__ . '\Factory\PhpDebugRenderFactory',
            __NAMESPACE__ . '\Options\BrandHelperOptions'      => __NAMESPACE__ . '\Factory\BrandHelperOptionsFactory',
            __NAMESPACE__ . '\Options\TrackingHelperOptions'   => __NAMESPACE__ . '\Factory\TrackingHelperOptionsFactory',
            __NAMESPACE__ . '\Options\PageHeaderHelperOptions' => __NAMESPACE__ . '\Factory\PageHeaderHelperOptionsFactory',
        ],
        'invokables' => [
            //'AsseticCacheBuster' => 'AsseticBundle\CacheBuster\LastModifiedStrategy',
        ]
    ],
    'assetic_configuration' => [
        'webPath'          => realpath('public/assets'),
        'basePath'         => 'assets',
        'default'          => [
            'assets'  => [
                '@libs',
                '@scripts',
                '@styles'
            ],
            'options' => [
                'mixin' => false
            ]
        ],
        'routes'           => [
            'entity/repository/add-revision' => [
                '@libs',
                '@editor_scripts',
                '@styles',
                '@editor_styles'
            ],
            'taxonomy/term/create'           => [
                '@libs',
                '@editor_scripts',
                '@styles',
                '@editor_styles'
            ],
            'taxonomy/term/update'           => [
                '@libs',
                '@editor_scripts',
                '@styles',
                '@editor_styles'
            ],
            'license/update'                 => [
                '@libs',
                '@editor_scripts',
                '@styles',
                '@editor_styles'
            ],
            'page/revision/create'           => [
                '@libs',
                '@editor_scripts',
                '@styles',
                '@editor_styles'
            ],
            'blog/post/create'               => [
                '@libs',
                '@editor_scripts',
                '@styles',
                '@editor_styles'
            ],
            'blog/post/update'               => [
                '@libs',
                '@editor_scripts',
                '@styles',
                '@editor_styles'
            ],
            'user/settings'               => [
                '@libs',
                '@editor_scripts',
                '@styles',
                '@editor_styles'
            ]
        ],
        'modules'          => [
            'ui' => [
                'root_path'   => __DIR__ . '/../../../assets/build',
                'collections' => [
                    'libs'           => [
                        'assets' => [
                            'bower_components/modernizr/modernizr.js',
                            'bower_components/requirejs/require.js'
                        ]
                    ],
                    'webcomponents' => [
                        'assets' => [
                            'bower_components/webcomponentsjs/webcomponents.js'
                        ]
                    ],
                    'scripts'        => [
                        'assets' => [
                            'scripts/main.js'
                        ]
                    ],
                    'styles'         => [
                        'assets'  => [
                            'styles/main.css',
                            '../node_modules/athene2-editor/build/styles/content.css'
                        ],
                        'filters' => [
                            '?CssRewriteFilter' => [
                                'name' => 'Assetic\Filter\CssRewriteFilter'
                            ],
                        ],
                    ],
                    'editor_scripts' => [
                        'assets' => [
                            '../node_modules/athene2-editor/build/scripts/editor.js'
                        ]
                    ],
                    'editor_styles'  => [
                        'assets' => [
                            '../node_modules/athene2-editor/build/styles/editor.css'
                        ]
                    ],
                    'main_fonts'     => [
                        'assets'  => [
                            'styles/fonts/*',
                            'styles/fonts/*.woff',
                            'styles/fonts/*.svg',
                            'styles/fonts/*.ttf'
                        ],
                        'options' => [
                            'move_raw' => true
                        ]
                    ],
                    'images'         => [
                        'assets'  => [
                            'images/*'
                        ],
                        'options' => [
                            'move_raw' => true
                        ]
                    ]
                ]
            ]
        ],
        'acceptableErrors' => [
            Application::ERROR_CONTROLLER_NOT_FOUND,
            Application::ERROR_CONTROLLER_INVALID,
            Application::ERROR_ROUTER_NO_MATCH,
            GuardInterface::GUARD_UNAUTHORIZED
        ]
    ]
];
