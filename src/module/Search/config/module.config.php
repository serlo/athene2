<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author       Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link         https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright    Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Search;

return [
    'di'              => [
        'allowed_controllers' => [
            __NAMESPACE__ . '\Controller\SearchController'
        ],
        'definition'          => [
            'class' => [
                __NAMESPACE__ . '\Controller\SearchController' => []
            ]
        ]
    ],
    'router'          => [
        'routes' => [
            'search' => [
                'type'          => 'literal',
                'options'       => [
                    'route'    => '/search',
                    'defaults' => [
                        'controller' => __NAMESPACE__ . '\Controller\SearchController',
                        'action'     => 'search'
                    ]
                ],
                'may_terminate' => true
            ],
        ]
    ]
];
