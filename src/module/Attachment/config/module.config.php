<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Attachment;

return [
    'zfc_rbac'           => [
        'assertion_map' => [
            'attachment.append'  => 'Authorization\Assertion\InstanceAssertion',
            'attachment.create'  => 'Authorization\Assertion\RequestInstanceAssertion',
            'attachment.get'     => 'Authorization\Assertion\InstanceAssertion',
            'attachment.trash'   => 'Authorization\Assertion\InstanceAssertion',
            'attachment.purge'   => 'Authorization\Assertion\InstanceAssertion',
            'attachment.restore' => 'Authorization\Assertion\InstanceAssertion'
        ]
    ],
    'class_resolver'     => [
        'Attachment\Entity\ContainerInterface' => 'Attachment\Entity\Container',
        'Attachment\Entity\FileInterface'      => 'Attachment\Entity\File'
    ],
    'attachment_manager' => [],
    'service_manager'    => [
        'factories' => [
            __NAMESPACE__ . '\Manager\AttachmentManager' => __NAMESPACE__ . '\Factory\AttachmentManagerFactory',
            __NAMESPACE__ . '\Options\ModuleOptions'     => __NAMESPACE__ . '\Factory\ModuleOptionsFactory'
        ]
    ],
    'uuid'               => [
        'permissions' => [
            'Attachment\Entity\Container' => [
                'trash'   => 'attachment.trash',
                'restore' => 'attachment.restore',
                'purge'   => 'attachment.purge'
            ],
        ]
    ],
    'di'                 => [
        'allowed_controllers' => [
            'Attachment\Controller\AttachmentController',
            'Taxonomy\Controller\TaxonomyController'
        ],
        'definition'          => [
            'class' => [
                'Attachment\Controller\AttachmentController' => [
                    'setAttachmentManager' => [
                        'required' => true
                    ]
                ],
            ]
        ],
        'instance'            => [
            'preferences' => [
                'Attachment\Manager\AttachmentManagerInterface' => 'Attachment\Manager\AttachmentManager'
            ],
        ]
    ],
    'doctrine'           => [
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
    ],
    'router'             => [
        'routes' => [
            'attachment' => [
                'type'    => 'literal',
                'options'      => [
                    'route'    => '/attachment',
                    'defaults' => [
                        'controller' => 'Attachment\Controller\AttachmentController',
                    ]
                ],
                'child_routes' => [
                    'info'   => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/info/:id',
                            'defaults' => [
                                'action' => 'info'
                            ]
                        ],
                    ],
                    'file'   => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/file/:id[/:file]',
                            'defaults' => [
                                'action' => 'file'
                            ]
                        ],
                    ],
                    'upload' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'    => '/upload[/:append]',
                            'defaults' => [
                                'action' => 'attach'
                            ]
                        ],
                    ]
                ]
            ],
        ]
    ]
];
