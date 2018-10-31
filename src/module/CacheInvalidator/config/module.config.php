<?php

/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Jakob Pfab (jakob.pfab@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace CacheInvalidator;

return [
    'service_manager'   => [
        'factories' => [
            __NAMESPACE__ . '\Listener\CacheListener'         => __NAMESPACE__ . '\Factory\CacheListenerFactory',
            __NAMESPACE__ . '\Invalidator\InvalidatorManager' => __NAMESPACE__ . '\Factory\InvalidatorManagerFactory',
            __NAMESPACE__ . '\Options\CacheOptions'           => __NAMESPACE__ . '\Factory\CacheOptionsFactory',
        ],
    ],
//    'cache_invalidator' => [
//        'invalidators' => [
//            'factories' => [
//                __NAMESPACE__ . '\Invalidator\NavigationStorageInvalidator' => __NAMESPACE__ . '\Factory\NavigationStorageInvalidatorFactory',
//                __NAMESPACE__ . '\Invalidator\StrokerStorageInvalidator'    => __NAMESPACE__ . '\Factory\StrokerStorageInvalidatorFactory',
//                __NAMESPACE__ . '\Invalidator\RepositoryStorageInvalidator' => __NAMESPACE__ . '\Factory\RepositoryStorageInvalidatorFactory',
//                __NAMESPACE__ . '\Invalidator\TaxonomyStorageInvalidator'   => __NAMESPACE__ . '\Factory\TaxonomyStorageInvalidatorFactory'
//            ]
//        ],
//        'listens'      => [
//            'Versioning\RepositoryManager'         => [
//                'checkout' => [
//                    __NAMESPACE__ . '\Invalidator\RepositoryStorageInvalidator'
//                ]
//            ],
//            'Taxonomy\Manager\TaxonomyManager'     => [
//                'create' => [
//                    __NAMESPACE__ . '\Invalidator\TaxonomyStorageInvalidator'
//                ],
//                'update' => [
//                    __NAMESPACE__ . '\Invalidator\TaxonomyStorageInvalidator'
//                ]
//            ],
//            'Navigation\Manager\NavigationManager' => [
//                'page.create'      => [
//                    __NAMESPACE__ . '\Invalidator\NavigationStorageInvalidator',
//                ],
//                'page.update'      => [
//                    __NAMESPACE__ . '\Invalidator\NavigationStorageInvalidator'
//                ],
//                'page.remove'      => [
//                    __NAMESPACE__ . '\Invalidator\NavigationStorageInvalidator',
//                ],
//                'parameter.create' => [
//                    __NAMESPACE__ . '\Invalidator\NavigationStorageInvalidator',
//                ],
//                'parameter.update' => [
//                    __NAMESPACE__ . '\Invalidator\NavigationStorageInvalidator',
//                ],
//                'parameter.remove' => [
//                    __NAMESPACE__ . '\Invalidator\NavigationStorageInvalidator',
//                ],
//            ]
//        ]
//    ]
];
