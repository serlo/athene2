<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Subject;

return [
    'service_manager' => [
        'factories' => [
            __NAMESPACE__ . '\Options\ModuleOptions'  => __NAMESPACE__ . '\Factory\ModuleOptionsFactory',
            __NAMESPACE__ . '\Manager\SubjectManager' => __NAMESPACE__ . '\Factory\SubjectManagerFactory',
            __NAMESPACE__ . '\Hydrator\Navigation'    => __NAMESPACE__ . '\Factory\NavigationFactory',
            __NAMESPACE__ . '\Storage\SubjectStorage' => __NAMESPACE__ . '\Factory\SubjectStorageFactory',
        ],
    ],
    'view_helpers'    => [
        'factories' => [
            'subject' => __NAMESPACE__ . '\Factory\SubjectHelperFactory',
        ],
    ],
    'taxonomy'        => [
        'types' => [
            'topic-folder'            => [
                'allowed_associations' => [
                    'Entity\Entity\EntityInterface',
                ],
                'allowed_parents'      => [
                    'topic',
                ],
                'rootable'             => false,
            ],
            'topic'                   => [
                'allowed_parents'      => [
                    'subject',
                    'topic',
                ],
                'allowed_associations' => [
                    'Entity\Entity\EntityInterface',
                ],
                'rootable'             => false,
            ],
            'subject'                 => [
                'allowed_parents' => [
                    'root',
                ],
                'rootable'        => false,
            ],
            'locale'                  => [
                'allowed_parents' => [
                    'subject',
                    'locale',
                ],
                'rootable'        => false,
            ],
            'curriculum'              => [
                'allowed_parents' => [
                    'subject',
                    'locale',
                ],
                'rootable'        => false,
            ],
            'curriculum-topic'        => [
                'allowed_associations' => [
                    'Entity\Entity\EntityInterface',
                ],
                'allowed_parents'      => [
                    'curriculum',
                    'curriculum-topic',
                ],
                'rootable'             => false,
            ],
            'curriculum-topic-folder' => [
                'allowed_associations' => [
                    'Entity\Entity\EntityInterface',
                ],
                'allowed_parents'      => [
                    'curriculum-topic',
                ],
                'rootable'             => false,
            ],
        ],
    ],
    'router'          => [
        'routes' => [
            'subject' => [
                'type'         => 'Subject',
                'options'      => [
                    'route'      => '/:subject',
                    'identifier' => 'subject',
                ],
                'child_routes' => [
                    'entity' => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/entity/:action',
                            'defaults' => [
                                'controller' => __NAMESPACE__ . '\Controller\EntityController',
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    //'home'   => [
                    //    'type'    => 'segment',
                    //    'options' => [
                    //        'route'    => '',
                    //        'defaults' => [
                    //            'controller' => __NAMESPACE__ . '\Controller\HomeController',
                    //            'action'     => 'index',
                    //        ]
                    //    ]
                    //]
                ],
            ],
        ],
    ],
    'route_manager'   => [
        'invokables' => [
            'Subject' => __NAMESPACE__ . '\Route\SubjectRoute',
        ],
    ],
    'di'              => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Controller\TaxonomyController',
            __NAMESPACE__ . '\Controller\EntityController',
            __NAMESPACE__ . '\Controller\HomeController',
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\Controller\HomeController'     => [
                    'setInstanceManager' => [
                        'required' => true,
                    ],
                    'setSubjectManager'  => [
                        'required' => true,
                    ],
                    'setTaxonomyManager' => [
                        'required' => true,
                    ],
                ],
                __NAMESPACE__ . '\Controller\TaxonomyController' => [
                    'setInstanceManager' => [
                        'required' => true,
                    ],
                    'setSubjectManager'  => [
                        'required' => true,
                    ],
                    'setTaxonomyManager' => [
                        'required' => true,
                    ],
                ],
                __NAMESPACE__ . '\Controller\EntityController'   => [
                    'setInstanceManager' => [
                        'required' => true,
                    ],
                    'setSubjectManager'  => [
                        'required' => true,
                    ],
                    'setTaxonomyManager' => [
                        'required' => true,
                    ],
                ],
            ],
        ],
        'instance'            => [
            'preferences' => [
                __NAMESPACE__ . '\Manager\SubjectManagerInterface' => __NAMESPACE__ . '\Manager\SubjectManager',
            ],
        ],
    ],
];
