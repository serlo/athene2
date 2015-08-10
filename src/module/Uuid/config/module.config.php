<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Uuid;

return [
    'service_manager' => [
        'factories' => [
            __NAMESPACE__ . '\Options\ModuleOptions' => __NAMESPACE__ . '\Factory\ModuleOptionsFactory',
            __NAMESPACE__ . '\Manager\UuidManager'   => __NAMESPACE__ . '\Factory\UuidManagerFactory'
        ]
    ],
    'class_resolver'  => [
        __NAMESPACE__ . '\Entity\UuidInterface' => __NAMESPACE__ . '\Entity\Uuid'
    ],
    'view_helpers'    => [
        'factories' => [
            'uuid' => __NAMESPACE__ . '\Factory\UuidHelperFactory'
        ]
    ],
    'uuid'            => [
    ],
    'router'          => [
        'routes' => [
            'uuid' => [
                'type'    => 'segment',
                'options'      => [
                    // Do not change this or /:id refs wont work (see normalizer route config)
                    'route' => ''
                ],
                'child_routes' => [
                    'trash'       => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/uuid/trash/:id',
                            'defaults' => [
                                'controller' => __NAMESPACE__ . '\Controller\UuidController',
                                'action'     => 'trash'
                            ]
                        ]
                    ],
                    'recycle-bin' => [
                        'type'    => 'literal',
                        'options' => [
                            'route'    => '/uuid/recycle-bin',
                            'defaults' => [
                                'controller' => __NAMESPACE__ . '\Controller\UuidController',
                                'action'     => 'recycleBin'
                            ]
                        ]
                    ],
                    'restore'     => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/uuid/restore/:id',
                            'defaults' => [
                                'controller' => __NAMESPACE__ . '\Controller\UuidController',
                                'action'     => 'restore'
                            ]
                        ]
                    ],
                    'purge'       => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/uuid/purge/:id',
                            'defaults' => [
                                'controller' => __NAMESPACE__ . '\Controller\UuidController',
                                'action'     => 'purge'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'di'              => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Controller\UuidController'
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\Controller\UuidController' => [
                    'setUuidManager' => [
                        'required' => true
                    ]
                ]
            ]
        ],
        'instance'            => [
            'preferences' => [
                __NAMESPACE__ . '\Manager\UuidManagerInterface' => __NAMESPACE__ . '\Manager\UuidManager'
            ]
        ]
    ],
    'doctrine'        => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'
                ]
            ],
            'orm_default'             => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]
];
