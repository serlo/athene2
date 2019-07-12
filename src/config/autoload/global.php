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
    'version' => '16',
    'brand' => [
        'instances' => [
            'deutsch' => [
                'name' => '<div class="serlo-brand">Serlo</div>',
                'slogan' => 'Die freie Lernplattform',
                'description' => 'Serlo ist eine kostenlose Plattform mit freien Lernmaterialien, die alle mitgestalten können.',
                'logo' => '<span class="serlo-logo">V</span>',
                'head_title' => 'lernen mit Serlo!',
            ],
            'english' => [
                'name' => '<div class="serlo-brand">Serlo</div>',
                'slogan' => 'The Open Learning Platform',
                'description' => 'Serlo is a free service with open educational resources, which anyone can contribute to.',
                'logo' => '<span class="serlo-logo">V</span>',
                'head_title' => 'learn with Serlo!',
            ],
            'spanish' => [
                'name' => '<div class="serlo-brand">Serlo</div>',
                'slogan' => 'La Plataforma para el Aprendizaje Abierto',
                'description' => 'Serlo es una plataforma abierta gratuita que ofrece recursos educativos, a los que todos pueden contribuir',
                'logo' => '<span class="serlo-logo">V</span>',
                'head_title' => 'aprende con Serlo!',
            ],
            'hindi' => [
                'name' => '<div class="serlo-brand">सेर्लो</div>',
                'slogan' => 'ओपन लर्निंग प्लेटफॉर्म',
                'description' => 'सेर्लो खुले शैक्षिक संसाधनों के साथ एक नि: शुल्क सेवा है, जो कोई भी योगदान दे सकता है.',
                'logo' => '<span class="serlo-logo">V</span>',
                'head_title' => 'सेर्लो के साथ सीखो!',
            ],
            'tamil' => [
                'name' => '<div class="serlo-brand">Serlo</div>',
                'slogan' => 'அனைவருக்கும் திறந்த உரிமம் உள்ள ஓர் இணையத் தளம்',
                'description' => 'Serlo அனைவருக்கும் ஒரு இலவச மற்றும் திறந்த உரிமம் உள்ள சேவை.',
                'logo' => '<span class="serlo-logo">V</span>',
                'head_title' => 'Serlo வுடன் கற்றுக்கொள்ளுங்கள்!',
            ],
        ],
    ],
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
    'assets' => [
        'assets_host' => 'https://packages.serlo.org/static-assets@1/',
        'bundle_host' => 'https://packages.serlo.org/athene2-assets@4/',
        'editor_renderer' => 'https://europe-west1-serlo-assets.cloudfunctions.net/editor-renderer-a',
    ],
];
