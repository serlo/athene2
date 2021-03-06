<?php
/**
 * This file is part of Athene2.
 *
 * Copyright (c) 2013-2019 Serlo Education e.V.
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
 * @copyright Copyright (c) 2013-2019 Serlo Education e.V.
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

return [
    'doctrine' => array(
        'configuration' => array(
            'orm_default' => array(
                'metadata_cache' => 'apccache',
                'query_cache' => 'apccache',
                'result_cache' => 'apccache',
                'hydration_cache' => 'apccache',
            ),
        ),
    ),
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
    'strokercache' => array(
        'storage_adapter' => [
            'name' => 'Zend\Cache\Storage\Adapter\Filesystem',
            'options' => [
                'cache_dir' => __DIR__ . '/../../data',
                'ttl' => 60 * 60 * 24 * 2,
            ],
        ],
    ),
];
