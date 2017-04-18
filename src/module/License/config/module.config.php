<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL]
 */
namespace License;

return [
    'zfc_rbac'        => [
        'assertion_map' => [
            'license.create' => 'Authorization\Assertion\RequestInstanceAssertion',
            'license.update' => 'Authorization\Assertion\InstanceAssertion',
            'license.purge'  => 'Authorization\Assertion\InstanceAssertion',
            'license.get'    => 'Authorization\Assertion\InstanceAssertion',
        ]
    ],
    'service_manager' => [
        'factories' => []
    ],
    'class_resolver'  => [
        __NAMESPACE__ . '\Entity\LicenseInterface' => __NAMESPACE__ . '\Entity\License'
    ],
    'di'              => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Controller\LicenseController'
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\Manager\LicenseManager'         => [],
                __NAMESPACE__ . '\Controller\LicenseController'   => [],
                __NAMESPACE__ . '\Listener\EntityManagerListener' => [
                    'setLicenseManager' => [
                        'required' => true
                    ]
                ],
            ]
        ],
        'instance'            => [
            'preferences' => [
                __NAMESPACE__ . '\Manager\LicenseManagerInterface' => __NAMESPACE__ . '\Manager\LicenseManager'
            ]
        ]
    ],
    'doctrine'        => [
        'driver'          => [
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
        ],
        'entity_resolver' => [
            'orm_default' => [
                'resolvers' => [
                    __NAMESPACE__ . '\Entity\LicenseInterface' => __NAMESPACE__ . '\Entity\License'
                ]
            ]
        ]
    ],
    'router'          => [
        'routes' => [
            'license' => [
                'type'    => 'literal',
                'options'      => [
                    'route'    => '/license',
                    'defaults' => [
                        'controller' => __NAMESPACE__ . '\Controller\LicenseController'
                    ]
                ],
                'child_routes' => [
                    'manage' => [
                        'type'    => 'literal',
                        'options' => [
                            'route'    => '/manage',
                            'defaults' => [
                                'action' => 'manage'
                            ]
                        ]
                    ],
                    'add'    => [
                        'type'    => 'literal',
                        'options' => [
                            'route'    => '/add',
                            'defaults' => [
                                'action' => 'add'
                            ]
                        ]
                    ],
                    'detail' => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/detail/:id',
                            'defaults' => [
                                'action' => 'detail'
                            ]
                        ]
                    ],
                    'update' => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/update/:id',
                            'defaults' => [
                                'action' => 'update'
                            ]
                        ]
                    ],
                    'remove' => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/remove/:id',
                            'defaults' => [
                                'action' => 'remove'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
