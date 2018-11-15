<?php

/**
 * This file is part of Athene2.
 *
 * Copyright (c) 2013-2018 Serlo Education e.V.
 *
 * Licensed under the Apache License, Version 2.0 (the "License")
 * you may not use this file except in compliance with the License
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @copyright Copyright (c) 2013-2018 Serlo Education e.V.
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

$cacher = [
    'adapter' => [
        'name' => 'Zend\Cache\Storage\Adapter\Memcached',
        'options' => [
            'namespace' => __NAMESPACE__,
            'servers' => [
                [
                    'host' => 'localhost',
                    'port' => 11211,
                ],
            ],
            'ttl' => 60 * 60,
        ],
    ],
    'plugins' => [
        'exception_handler' => [
            'throw_exceptions' => false,
        ],
        'serializer',
    ],
];

return [
    'doctrine' => array(
        'configuration' => array(
            'orm_default' => array(
                'metadata_cache' => 'doctrine_memcache',
                'query_cache' => 'doctrine_memcache',
                'result_cache' => 'doctrine_memcache',
                'hydration_cache' => 'doctrine_memcache',
            ),
        ),
    ),
    'service_manager' => [
        'factories' => [
            'doctrine.cache.doctrine_memcache' => function ($sm) {
                $cache = new \Doctrine\Common\Cache\MemcachedCache();
                $memcache = new \Memcached();
                $memcache->addServer('localhost', 11211);
                $cache->setMemcached($memcache);
                return $cache;
            },
        ],
    ],
    'view_manager' => [
        'display_exceptions' => false,
    ],
    'zfctwig' => [
        'environment_options' => [
            'debug' => false,
            'strict_variables' => false,
            'autoescape' => false,
        ],
    ],
    'log' => [
        'exceptions' => true,
    ],
    'strokercache' => [
        'storage_adapter' => [
            'name' => 'Zend\Cache\Storage\Adapter\Memcached',
            'options' => [
                'servers' => [
                    [
                        'host' => 'localhost',
                        'port' => 11211,
                    ],
                ],
                'ttl' => 60 * 60 * 24 * 2,
            ],
        ],
    ],
    'alias_cache' => $cacher,
    'markdown_cache' => $cacher,
    'navigation_cache' => $cacher,
    'normalizer_cache' => $cacher,
    'notification_cache' => $cacher,
    'subject_cache' => $cacher,
];
