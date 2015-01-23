<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Authentication;

return [
    'service_manager' => [
        'factories' => [
            'Zend\Authentication\AuthenticationService'   => __NAMESPACE__ . '\Factory\AuthenticationServiceFactory',
            __NAMESPACE__ . '\Storage\UserSessionStorage' => __NAMESPACE__ . '\Factory\UserSessionStorageFactory',
            __NAMESPACE__ . '\HashService'                => __NAMESPACE__ . '\Factory\HashServiceFactory'

        ]
    ],
    'controllers'     => [
        'factories' => [
            __NAMESPACE__ . '\Controller\AuthenticationController' => __NAMESPACE__ . '\Factory\AuthenticationControllerFactory'
        ]
    ],
    'di'              => [
        'instance' => [
            'preferences' => [
                __NAMESPACE__ . '\HashServiceInterface'     => __NAMESPACE__ . '\HashService',
                __NAMESPACE__ . '\Adapter\AdapterInterface' => __NAMESPACE__ . '\Adapter\UserAuthAdapter',
            ]
        ]
    ],
    'router'          => [
        'routes' => [
            'authentication' => [
                'type'    => 'literal',
                'options'      => [
                    'route'    => '/auth',
                    'defaults' => [
                        'controller' => __NAMESPACE__ . '\Controller\AuthenticationController',
                    ]
                ],
                'child_routes' => [
                    'login'    => [
                        'type'    => 'literal',
                        'may_terminate' => true,
                        'options'       => [
                            'route'    => '/login',
                            'defaults' => [
                                'action' => 'login'
                            ]
                        ]
                    ],
                    'logout'   => [
                        'type'    => 'literal',
                        'may_terminate' => true,
                        'options'       => [
                            'route'    => '/logout',
                            'defaults' => [
                                'action' => 'logout'
                            ]
                        ]
                    ],
                    'activate' => [
                        'type'          => 'segment',
                        'may_terminate' => true,
                        'options'       => [
                            'route'    => '/activate[/:token]',
                            'defaults' => [
                                'action' => 'activate'
                            ]
                        ]
                    ],
                    'password' => [
                        'type'    => 'literal',
                        'options'      => [
                            'route' => '/password'
                        ],
                        'child_routes' => [
                            'change'  => [
                                'type'    => 'literal',
                                'may_terminate' => true,
                                'options'       => [
                                    'route'    => '/change',
                                    'defaults' => [
                                        'action' => 'changePassword'
                                    ]
                                ]
                            ],
                            'restore' => [
                                'type'          => 'segment',
                                'may_terminate' => true,
                                'options'       => [
                                    'route'    => '/restore[/:token]',
                                    'defaults' => [
                                        'action' => 'restorePassword'
                                    ]
                                ]
                            ]
                        ]
                    ],
                ]
            ]
        ]
    ]
];
