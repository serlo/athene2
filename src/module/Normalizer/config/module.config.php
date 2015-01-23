<?php

/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Normalizer;

return [
    'view_helpers'    => [
        'factories' => [
            'normalize' => __NAMESPACE__ . '\Factory\NormalizeHelperFactory'
        ]
    ],
    'service_manager' => [
        'factories' => [
            __NAMESPACE__ . '\Normalizer'      => __NAMESPACE__ . '\Factory\NormalizerFactory',
            __NAMESPACE__ . '\Storage\Storage' => __NAMESPACE__ . '\Factory\NormalizerStorageFactory'
        ]
    ],
    'normalizer'      => [
        'strategies' => [
            __NAMESPACE__ . '\Strategy\AttachmentStrategy'     => [],
            __NAMESPACE__ . '\Strategy\CommentStrategy'        => [],
            __NAMESPACE__ . '\Strategy\EntityRevisionStrategy' => [],
            __NAMESPACE__ . '\Strategy\EntityStrategy'         => [],
            __NAMESPACE__ . '\Strategy\PageRepositoryStrategy' => [],
            __NAMESPACE__ . '\Strategy\PageRevisionStrategy'   => [],
            __NAMESPACE__ . '\Strategy\PostStrategy'           => [],
            __NAMESPACE__ . '\Strategy\TaxonomyTermStrategy'   => [],
            __NAMESPACE__ . '\Strategy\UserStrategy'           => [],
        ]
    ],
    'di'              => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Controller\SignpostController',
            __NAMESPACE__ . '\Controller\SitemapController'
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\Controller\SignpostController' => [
                    'setNormalizer'  => [
                        'required' => true
                    ],
                    'setUuidManager' => [
                        'required' => true
                    ]
                ]
            ]
        ],
        'instance'            => [
            'preferences' => [
                __NAMESPACE__ . '\NormalizerInterface' => __NAMESPACE__ . '\Normalizer'
            ]
        ]
    ],
    'console'         => [
        'router' => [
            'routes' => [
                'sitemap' => [
                    'options' => [
                        'route'    => 'sitemap',
                        'defaults' => [
                            'controller' => __NAMESPACE__ . '\Controller\SitemapController',
                            'action'     => 'index'
                        ]
                    ]
                ],
            ]
        ],
    ],
    'router'          => [
        'routes' => [
            'meta' => [
                'type'    => 'segment',
                'options' => [
                    'route'    => '/meta/:id',
                    'defaults' => [
                        'controller' => __NAMESPACE__ . '\Controller\SignpostController',
                        'action'     => 'meta'
                    ]
                ]
            ],
            'normalizer' => [
                'type'         => 'segment',
                'options'      => [
                    'route' => ''
                ],
                'child_routes' => [
                    'signpost' => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/ref/:object',
                            'defaults' => [
                                'controller' => __NAMESPACE__ . '\Controller\SignpostController',
                                'action'     => 'ref'
                            ]
                        ]
                    ]
                ]
            ],
            'sitemap'    => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/sitemap',
                    'defaults' => [
                        'controller' => __NAMESPACE__ . '\Controller\SitemapController',
                    ],
                ],
                'child_routes' => [
                    'uuid' => [
                        'type'    => 'literal',
                        'options'  => [
                            'route'    => '/uuid.xml',
                            'defaults'    => [
                                'action'     => 'uuid'
                            ],
                        ]
                    ],
                    'navigation' => [
                        'type'    => 'literal',
                        'options'  => [
                            'route'    => '/nav.xml',
                            'defaults'    => [
                                'action'     => 'index'
                            ],
                        ]
                    ]
                ]
            ],
            'uuid'       => [
                'child_routes' => [
                    'get' => [
                        'type'     => 'segment',
                        'priority' => -9000,
                        'options'  => [
                            'route'       => '/:uuid',
                            'defaults'    => [
                                'controller' => __NAMESPACE__ . '\Controller\SignpostController',
                                'action'     => 'index'
                            ],
                            'constraints' => [
                                'uuid' => '[0-9]+'
                            ],
                        ]
                    ],
                ]
            ]
        ]
    ]
];
