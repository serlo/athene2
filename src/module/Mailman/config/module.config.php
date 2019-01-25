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

namespace Mailman;

use Mailman\Controller\WorkerController;
use Mailman\Factory\MailmanFactory;
use Mailman\Factory\MailmanWorkerListenerFactory;
use Mailman\Listener\MailmanWorkerListener;

return [
    'mailman' => [
        'adapters' => [
            'Mailman\Adapter\ZendMailAdapter',
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'mailman-worker' => [
                    'options' => [
                        'route' => 'mailman worker',
                        'defaults' => [
                            'controller' => WorkerController::class,
                            'action' => 'run',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Mailman::class => MailmanFactory::class,
            __NAMESPACE__ . '\Options\ModuleOptions' => __NAMESPACE__ . '\Factory\ModuleOptionsFactory',
            __NAMESPACE__ . '\Adapter\ZendMailAdapter' => __NAMESPACE__ . '\Factory\ZendMailAdapterFactory',
            __NAMESPACE__ . '\Listener\AuthenticationControllerListener' => __NAMESPACE__ . '\Factory\AuthenticationControllerListenerFactory',
            __NAMESPACE__ . '\Listener\UserControllerListener' => __NAMESPACE__ . '\Factory\UserControllerListenerFactory',
            __NAMESPACE__ . '\Listener\NotificationWorkerListener' => __NAMESPACE__ . '\Factory\NotificationWorkerListenerFactory',
            MailmanWorkerListener::class => MailmanWorkerListenerFactory::class,
            'Zend\Mail\Transport\SmtpOptions' => __NAMESPACE__ . '\Factory\SmtpOptionsFactory',
        ],
    ],
    'smtp_options' => [
        'name' => 'localhost.localdomain',
        'host' => 'localhost',
        'connection_class' => 'smtp',
        'connection_config' => [
            'username' => 'postmaster',
            'password' => '',
        ],
    ],
    'di' => [
        'allowed_controllers' => [
            WorkerController::class,
        ],
        'definition' => [
            'class' => [
                MailmanWorker::class => [
                    'setClassResolver' => [
                        'required' => true,
                    ],
                    'setObjectManager' => [
                        'required' => true,
                    ],
                ],
                WorkerController::class => [
                    'setMailmanWorker' => [
                        'required' => true,
                    ],
                ],
            ],
        ],
        'instance' => [
            'preferences' => [
                MailmanInterface::class => Mailman::class,
            ],
        ],
    ],
];
