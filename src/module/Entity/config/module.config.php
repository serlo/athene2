<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license        LGPL-3.0
 * @license        http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Entity;

return [
    'zfc_rbac'        => [
        'assertion_map' => [
            'entity.create'             => 'Authorization\Assertion\InstanceAssertion',
            'entity.get'                => 'Authorization\Assertion\InstanceAssertion',
            'entity.trash'              => 'Authorization\Assertion\InstanceAssertion',
            'entity.purge'              => 'Authorization\Assertion\InstanceAssertion',
            'entity.restore'            => 'Authorization\Assertion\InstanceAssertion',
            'entity.revision.create'    => 'Authorization\Assertion\InstanceAssertion',
            'entity.revision.purge'     => 'Authorization\Assertion\InstanceAssertion',
            'entity.revision.restore'   => 'Authorization\Assertion\InstanceAssertion',
            'entity.revision.trash'     => 'Authorization\Assertion\InstanceAssertion',
            'entity.revision.checkout'  => 'Authorization\Assertion\InstanceAssertion',
            'entity.repository.history' => 'Authorization\Assertion\InstanceAssertion',
            'entity.link.create'        => 'Authorization\Assertion\InstanceAssertion',
            'entity.link.purge'         => 'Authorization\Assertion\InstanceAssertion',
            'entity.link.order'         => 'Authorization\Assertion\InstanceAssertion',
            'entity.license.update'     => 'Authorization\Assertion\InstanceAssertion',
        ]
    ],
    'class_resolver'  => [
        'Entity\Entity\EntityInterface' => 'Entity\Entity\Entity',
        'Entity\Entity\TypeInterface'   => 'Entity\Entity\Type'
    ],
    'di'              => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Controller\EntityController',
            __NAMESPACE__ . '\Controller\RepositoryController',
            __NAMESPACE__ . '\Controller\PageController',
            __NAMESPACE__ . '\Controller\TaxonomyController',
            __NAMESPACE__ . '\Controller\LinkController',
            __NAMESPACE__ . '\Controller\LicenseController'
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\Controller\TaxonomyController'   => [
                    'setEntityManager'   => [
                        'required' => true
                    ],
                    'setTaxonomyManager' => [
                        'required' => true
                    ],
                    'setInstanceManager' => [
                        'required' => true
                    ]
                ],
                __NAMESPACE__ . '\Controller\LinkController'       => [
                    'setEntityManager' => [
                        'required' => true
                    ],
                    'setLinkService'   => [
                        'required' => true
                    ],
                    'setModuleOptions' => [
                        'required' => true
                    ]
                ],
                __NAMESPACE__ . '\Controller\LicenseController'    => [
                    'setEntityManager'   => [
                        'required' => true
                    ],
                    'setInstanceManager' => [
                        'required' => true
                    ],
                    'setLicenseManager'  => [
                        'required' => true
                    ]
                ],
                __NAMESPACE__ . '\Controller\EntityController'     => [
                    'setEntityManager'   => [
                        'required' => true
                    ],
                    'setInstanceManager' => [
                        'required' => true
                    ]
                ],
                __NAMESPACE__ . '\Controller\RepositoryController' => [
                    'setEntityManager'        => [
                        'required' => true
                    ],
                    'setInstanceManager'      => [
                        'required' => true
                    ],
                    'setUserManager'          => [
                        'required' => true
                    ],
                    'setRepositoryManager'    => [
                        'required' => true
                    ],
                    'setModuleOptions'        => [
                        'required' => true
                    ],
                    'setAuthorizationService' => [
                        'required' => true
                    ]
                ],
                __NAMESPACE__ . '\Controller\PageController'       => [
                    'setEntityManager' => [
                        'required' => true
                    ]
                ],
                __NAMESPACE__ . '\Manager\EntityManager'           => [
                    'setUuidManager'          => [
                        'required' => true
                    ],
                    'setObjectManager'        => [
                        'required' => true
                    ],
                    'setClassResolver'        => [
                        'required' => true
                    ],
                    'setTypeManager'          => [
                        'required' => true
                    ],
                    'setAuthorizationService' => [
                        'required' => true
                    ]
                ],
                __NAMESPACE__ . '\Provider\TokenProvider'          => []
            ]
        ],
        'instance'            => [
            'preferences' => [
                'Entity\Manager\EntityManagerInterface' => 'Entity\Manager\EntityManager'
            ]
        ]
    ],
    'service_manager' => [
        'factories' => [
            __NAMESPACE__ . '\Options\ModuleOptions'        => __NAMESPACE__ . '\Factory\ModuleOptionsFactory',
            __NAMESPACE__ . '\Form\ArticleForm'             => __NAMESPACE__ . '\Factory\ArticleFormFactory',
            __NAMESPACE__ . '\Form\GroupedTextExerciseForm' => __NAMESPACE__ . '\Factory\GroupedTextExerciseFormFactory',
            __NAMESPACE__ . '\Form\ModuleForm'              => __NAMESPACE__ . '\Factory\ModuleFormFactory',
            __NAMESPACE__ . '\Form\ModulePageForm'          => __NAMESPACE__ . '\Factory\ModulePageFormFactory',
            __NAMESPACE__ . '\Form\TextExerciseForm'        => __NAMESPACE__ . '\Factory\TextExerciseFormFactory',
            __NAMESPACE__ . '\Form\TextExerciseGroupForm'   => __NAMESPACE__ . '\Factory\TextExerciseGroupFormFactory',
            __NAMESPACE__ . '\Form\TextSolutionForm'        => __NAMESPACE__ . '\Factory\TextSolutionFormFactory',
            __NAMESPACE__ . '\Form\TextHintForm'            => __NAMESPACE__ . '\Factory\TextHintFormFactory',
            __NAMESPACE__ . '\Form\VideoForm'               => __NAMESPACE__ . '\Factory\VideoFormFactory'
        ]
    ],
    'controllers'     => [
        'factories' => [
            __NAMESPACE__ . '\Controller\ApiController' => __NAMESPACE__ . '\Factory\ApiControllerFactory'
        ]
    ],
    'view_helpers'    => [
        'factories' => [
            'entity' => __NAMESPACE__ . '\Factory\EntityHelperFactory'
        ]
    ],
    'uuid'            => [
        'permissions' => [
            'Entity\Entity\Revision' => [
                'trash'   => 'entity.revision.trash',
                'restore' => 'entity.revision.restore',
                'purge'   => 'entity.revision.purge'
            ],
            'Entity\Entity\Entity'   => [
                'trash'   => 'entity.trash',
                'restore' => 'entity.restore',
                'purge'   => 'entity.purge'
            ]
        ]
    ],
    'versioning'      => [
        'permissions' => [
            'Entity\Entity\Entity' => [
                'commit'   => 'entity.revision.create',
                'checkout' => 'entity.revision.checkout',
                'reject'   => 'entity.revision.trash'
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
