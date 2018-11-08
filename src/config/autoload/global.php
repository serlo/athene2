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
return [
    'zfctwig'         => [
        'environment_options' => [
            'cache' => __DIR__ . '/../../data/twig',
        ],
        'extensions'          => [
            'Twig_Extensions_Extension_I18n',
        ],
    ],
    'doctrine'        => [
        'entitymanager' => [
            'orm_default' => [
                'connection'    => 'orm_default',
                'configuration' => 'orm_default',
            ],
        ],
    ],
    'router'          => [
        'router_class' => 'Zend\Mvc\Router\Http\TranslatorAwareTreeRouteStack',
    ],
    'session'         => [
        'config'     => [
            'class'   => 'Zend\Session\Config\SessionConfig',
            'options' => [
                'name'                => 'athene2',
                'cookie_lifetime'     => 2419200,
                'remember_me_seconds' => 2419200,
                'use_cookies'         => true,
                'cookie_secure'       => false,
            ],
        ],
        'storage'    => 'Zend\Session\Storage\SessionArrayStorage',
        'validators' => [
            'Zend\Session\Validator\RemoteAddr',
            'Zend\Session\Validator\HttpUserAgent',
        ],
    ],
    'di'              => [
        'instance' => [
            'preferences' => [
                'Zend\ServiceManager\ServiceLocatorInterface' => 'ServiceManager',
                'Doctrine\Common\Persistence\ObjectManager'   => 'Doctrine\ORM\EntityManager',
            ],
        ],
    ],
    'sphinx'          => [
        'host' => '127.0.0.1',
        'port' => 9306,
    ],
    'zendDiCompiler'  => [],
    'zfc_rbac'        => [
        'redirect_strategy' => [
            'redirect_to_route_connected'    => 'authorization/forbidden',
            'redirect_to_route_disconnected' => 'authentication/login',
            'append_previous_uri'            => true,
            'previous_uri_query_key'         => 'redir',
        ],
    ],
    'assets_host'     => 'https://packages.serlo.org/athene2-assets@a/',
    'editor_renderer' => [
        'url' => 'https://europe-west1-serlo-assets.cloudfunctions.net/editor-renderer-a',
    ],
];
