<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Contexter;

return [
    'router' => [
        'routes' => [
            'contexter' => [
                'type'    => 'literal',
                'options'      => [
                    'route'    => '/context',
                    'defaults' => [
                        'controller' => __NAMESPACE__ . '\Controller\ContextController'
                    ]
                ],
                'child_routes' => [
                    'select-uri' => [
                        'type'    => 'literal',
                        'options' => [
                            'route'    => '/select-uri',
                            'defaults' => [
                                'action' => 'selectUri'
                            ]
                        ]
                    ],
                    'route'      => [
                        'type'    => 'literal',
                        'options'      => [
                            'route' => '/route'
                        ],
                        'child_routes' => [
                            'remove' => [
                                'type'    => 'segment',
                                'options' => [
                                    'route'    => '/remove/:id',
                                    'defaults' => [
                                        'action' => 'removeRoute'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'remove'     => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/remove/:id',
                            'defaults' => [
                                'action' => 'remove'
                            ]
                        ]
                    ],
                    'add'        => [
                        'type'    => 'literal',
                        'options' => [
                            'route'    => '/add',
                            'defaults' => [
                                'action' => 'add'
                            ]
                        ]
                    ],
                    'manage'     => [
                        'type'    => 'literal',
                        'options' => [
                            'route'    => '/manage',
                            'defaults' => [
                                'action' => 'manage'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
];
