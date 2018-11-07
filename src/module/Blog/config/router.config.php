<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Blog;

return [
    'router' => [
        'routes' => [
            'blog' => [
                'type'    => 'literal',
                'options'       => [
                    'route'    => '/blog',
                    'defaults' => [
                        'controller' => __NAMESPACE__ . '\Controller\BlogController',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'view-all' => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/view-all/:id',
                            'defaults' => [
                                'action' => 'viewAll',
                            ],
                        ],
                    ],
                    'view'     => [
                        'type'    => 'segment',
                        'options' => [
                            'route'    => '/view/:id',
                            'defaults' => [
                                'action' => 'view',
                            ],
                        ],
                    ],
                    'post'     => [
                        'type'    => 'literal',
                        'options'      => [
                            'route' => '/post',
                        ],
                        'child_routes' => [
                            'create' => [
                                'type'    => 'segment',
                                'options' => [
                                    'route'    => '/create/:id',
                                    'defaults' => [
                                        'action' => 'create',
                                    ],
                                ],
                            ],
                            'view'   => [
                                'type'    => 'segment',
                                'options' => [
                                    'route'    => '/view/:post',
                                    'defaults' => [
                                        'action' => 'viewPost',
                                    ],
                                ],
                            ],
                            'update' => [
                                'type'    => 'segment',
                                'options' => [
                                    'route'    => '/update/:post',
                                    'defaults' => [
                                        'action' => 'update',
                                    ],
                                ],
                            ],
                            'trash'  => [
                                'type'    => 'segment',
                                'options' => [
                                    'route'    => '/trash/:post',
                                    'defaults' => [
                                        'action' => 'trash',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
