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
namespace Event;

return [
    'zfc_rbac'        => [
        'assertion_map' => [
            'event.log.get' => 'Authorization\Assertion\InstanceAssertion',
        ]
    ],
    'event_manager'   => [],
    'class_resolver'  => [
        'Event\Entity\EventLogInterface'           => 'Event\Entity\EventLog',
        'Event\Entity\EventInterface'              => 'Event\Entity\Event',
        'Event\Entity\EventParameterInterface'     => 'Event\Entity\EventParameter',
        'Event\Entity\EventParameterNameInterface' => 'Event\Entity\EventParameterName',
        'Event\Service\EventServiceInterface'      => 'Event\Service\EventService'
    ],
    'view_helpers'    => [
        'factories' => [
            'eventLog' => __NAMESPACE__ . '\Factory\EventLogHelperFactory'
        ]
    ],
    'zfctwig'         => [
        'helper_manager' => [
            'factories' => [
                'eventLog' => __NAMESPACE__ . '\Factory\EventLogHelperFactory'
            ]
        ]
    ],
    'controllers'     => [
        'invokables' => [__NAMESPACE__ . '\Controller\EventController']
    ],
    'service_manager' => [
        'factories' => [
            'Event\Listener\RepositoryManagerListener' => __NAMESPACE__ . '\Factory\RepositoryManagerListenerFactory',
            'Event\Listener\DiscussionManagerListener' => __NAMESPACE__ . '\Factory\DiscussionManagerListenerFactory',
            'Event\Listener\TaxonomyManagerListener'   => __NAMESPACE__ . '\Factory\TaxonomyManagerListenerFactory',
            'Event\Listener\UuidManagerListener'       => __NAMESPACE__ . '\Factory\UuidManagerListenerFactory',
            'Event\Listener\LinkServiceListener'       => __NAMESPACE__ . '\Factory\LinkServiceListenerFactory',
            'Event\Listener\EntityManagerListener'     => __NAMESPACE__ . '\Factory\EntityManagerListenerFactory',
            'Event\Listener\LicenseManagerListener'    => __NAMESPACE__ . '\Factory\LicenseManagerListenerFactory',
            'Event\EventManager'                       => __NAMESPACE__ . '\Factory\EventManagerFactory'
        ]
    ],
    'di'              => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Controller\EventController'
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\EventManager' => [
                    'setClassResolver'  => [
                        'required' => true
                    ],
                    'setObjectManager'  => [
                        'required' => true
                    ],
                    'setServiceLocator' => [
                        'required' => true
                    ]
                ]
            ]
        ],
        'instance'            => [
            'preferences'                           => [
                __NAMESPACE__ . '\EventManagerInterface' => __NAMESPACE__ . '\EventManager'
            ],
            __NAMESPACE__ . '\Service\EventService' => [
                'shared' => false
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
    ],
    'router'          => [
        'routes' => [
            'event' => [
                'type'    => 'literal',
                'options'      => [
                    'route'    => '/event',
                    'defaults' => [
                        'controller' => __NAMESPACE__ . '\Controller\EventController'
                    ]
                ],
                'child_routes' => [
                    'history' => [
                        'type'    => 'literal',
                        'options'      => [
                            'route'    => '/history',
                        ],
                        'child_routes' => [
                            'object' => [
                                'type'    => 'segment',
                                'options' => [
                                    'route'    => '/:id',
                                    'defaults' => [
                                        'action' => 'history'
                                    ]
                                ]
                            ],
                            'all'     => [
                                'type'    => 'segment',
                                'options' => [
                                    'route'    => '',
                                    'defaults' => [
                                        'action' => 'all'
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
