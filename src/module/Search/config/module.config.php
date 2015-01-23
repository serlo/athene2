<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author       Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license      LGPL-3.0
 * @license      http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link         https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright    Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Search;

return [
    'service_manager' => [
        'invokables' => [
            'Search\Adapter\AdapterPluginManager',
            'Search\Adapter\ProviderPluginManager'
        ],
        'factories'  => [
            __NAMESPACE__ . '\SearchService'                      => __NAMESPACE__ . '\Factory\SearchServiceFactory',
            __NAMESPACE__ . '\Options\ModuleOptions'              => __NAMESPACE__ . '\Factory\ModuleOptionsFactory',
            __NAMESPACE__ . '\Listener\RepositoryManagerListener' => __NAMESPACE__ . '\Factory\RepositoryManagerListenerFactory',
            __NAMESPACE__ . '\Listener\UuidManagerListener'       => __NAMESPACE__ . '\Factory\UuidManagerListenerFactory',
            __NAMESPACE__ . '\Listener\TaxonomyManagerListener'   => __NAMESPACE__ . '\Factory\TaxonomyManagerListenerFactory',
        ]
    ],
    'di'              => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Controller\SearchController',
            __NAMESPACE__ . '\Controller\IndexController'
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\Controller\SearchController' => [],
                __NAMESPACE__ . '\Controller\IndexController'  => []
            ]
        ],
        'instance'            => [
            'preferences' => [
                __NAMESPACE__ . '\SearchServiceInterface' => __NAMESPACE__ . '\SearchService'
            ]
        ]
    ],
    'view_helpers'    => [
        'invokables' => [
            'search' => __NAMESPACE__ . '\View\Helper\SearchHelper',
        ]
    ],
    'zfctwig'         => [
        'helper_manager' => [
            'invokables' => [
                'search' => __NAMESPACE__ . '\View\Helper\SearchHelper',
            ],
        ]
    ],
    'search'          => [
        'adapter'   => __NAMESPACE__ . '\Adapter\SolrAdapter',
        'providers' => [
            __NAMESPACE__ . '\Provider\EntityProvider',
            __NAMESPACE__ . '\Provider\TaxonomyProvider',
        ]
    ],
    'console'         => [
        'router' => [
            'routes' => [
                'search' => [
                    'options' => [
                        'route'    => 'search rebuild',
                        'defaults' => [
                            'controller' => __NAMESPACE__ . '\Controller\IndexController',
                            'action'     => 'rebuild'
                        ]
                    ]
                ],
            ]
        ],
    ],
    'router'          => [
        'routes' => [
            'search' => [
                'type'          => 'literal',
                'options'       => [
                    'route'    => '/search',
                    'defaults' => [
                        'controller' => __NAMESPACE__ . '\Controller\SearchController',
                        'action'     => 'search'
                    ]
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'ajax' => [
                        'type'    => 'literal',
                        'options' => [
                            'route'    => '/ajax',
                            'defaults' => [
                                'action' => 'ajax'
                            ]
                        ]
                    ]
                ]
            ],
        ]
    ]
];
