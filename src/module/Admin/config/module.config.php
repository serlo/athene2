<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Admin;

return [
    'router' => [
        'routes' => [
            'backend'  => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/backend',
                    'defaults' => [
                        'controller' => 'Admin\Controller\HomeController',
                        'action'     => 'index'
                    ]
                ],
            ],
            'debugger' => [
                'type'    => 'literal',
                'options' => [
                    'route'    => '/debugger',
                    'defaults' => [
                        'controller' => 'Admin\Controller\DebuggerController',
                        'action'     => 'index'
                    ]
                ],
            ]
        ]
    ],
    'di'     => [
        'allowed_controllers' => [
            'Admin\Controller\HomeController',
            'Admin\Controller\DebuggerController'
        ],
        'definition'          => [
            'class' => [
                'Admin\Controller\HomeController' => [
                ]
            ]
        ]
    ]
];