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
namespace Common;

return [
    'controller_plugins' => [
        'invokables' => [
            'referer'  => 'Common\Controller\Plugin\RefererProvider',
            'redirect' => 'Common\Controller\Plugin\RedirectHelper'
        ]
    ],
    'route_manager'      => [
        'invokables' => [
            'slashable' => __NAMESPACE__ . '\Router\Slashable'
        ]
    ],
    'service_manager'    => [
        'factories' => [
            __NAMESPACE__ . '\Hydrator\HydratorPluginAwareDoctrineObject' => __NAMESPACE__ . '\Factory\HydratorPluginAwareDoctrineObjectFactory',
            __NAMESPACE__ . '\Hydrator\HydratorPluginManager'             => __NAMESPACE__ . '\Factory\HydratorPluginManagerFactory',
            'doctrine.cache.apccache'                                     => __NAMESPACE__ . '\Factory\ApcCacheFactory'
        ]
    ]
];
