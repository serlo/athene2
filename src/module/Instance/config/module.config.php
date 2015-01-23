<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Instance;

return [
    'zfc_rbac'           => [
        'assertion_map' => [
            'instance.get' => 'Authorization\Assertion\InstanceAssertion',
        ]
    ],
    'doctrine_factories' => [
        'entitymanager' => __NAMESPACE__ . '\Factory\InstanceAwareEntityManagerFactory',
    ],
    'router'             => [
        'routes' => [
            'instance' => [
                'type'         => 'literal',
                'options'      => [
                    'route'    => '/instance',
                    'defaults' => [
                        'controller' => __NAMESPACE__ . '\Controller\InstanceController'
                    ]
                ],
                'child_routes' => [
                    'switch' => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/switch/:instance',
                            'defaults' => [
                                'action' => 'switch'
                            ]
                        ]
                    ],
                ]
            ]
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
    'view_helpers'       => [
        'factories' => [
            'instance' => __NAMESPACE__ . '\Factory\InstanceHelperFactory'
        ]
    ],
    'controllers'        => [
        'factories' => [
            __NAMESPACE__ . '\Controller\InstanceController' => __NAMESPACE__ . '\Factory\InstanceControllerFactory'
        ]
    ],
    'service_manager'    => [
        'invokables' => [
            __NAMESPACE__ . '\Strategy\StrategyPluginManager'
        ],
        'factories'  => [
            __NAMESPACE__ . '\Manager\InstanceManager'            => __NAMESPACE__ . '\Factory\InstanceManagerFactory',
            __NAMESPACE__ . '\Options\InstanceOptions'            => __NAMESPACE__ . '\Factory\InstanceOptionsFactory',
            __NAMESPACE__ . '\Listener\IsolationBypassedListener' => __NAMESPACE__ . '\Factory\IsolationBypassedListenerFactory',
            'Zend\I18n\Translator\TranslatorInterface'            => 'Zend\I18n\Translator\TranslatorServiceFactory'
        ]
    ],
    'di'                 => [
        'instance' => [
            'preferences' => [
                __NAMESPACE__ . '\Manager\InstanceManagerInterface' => __NAMESPACE__ . '\Manager\InstanceManager'
            ],
        ]
    ],
    'class_resolver'     => [
        __NAMESPACE__ . '\Entity\InstanceInterface' => __NAMESPACE__ . '\Entity\Instance',
    ]
];
