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

use FeatureFlags\Service;
use Mailman\Listener\MailmanWorkerListener;
use Mailman\Listener\NotificationWorkerListener;
use Mailman\Options\ModuleOptions;
use Zend\Console\Request;
use Zend\Mvc\MvcEvent;
use Zend\Uri\Http;
use Zend\View\Helper\ServerUrl;

class Module
{
    public static $listeners = [
        'Mailman\Listener\UserControllerListener',
        'Mailman\Listener\AuthenticationControllerListener',
    ];

    public function getAutoloaderConfig()
    {
        $autoloader = [];

        $autoloader['Zend\Loader\StandardAutoloader'] = [
            'namespaces' => [
                __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
            ],
        ];

        if (file_exists(__DIR__ . '/autoload_classmap.php')) {
            return [
                'Zend\Loader\ClassMapAutoloader' => [
                    __DIR__ . '/autoload_classmap.php',
                ],
            ];
        }

        return $autoloader;
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatchRegisterListeners'), 1000);
    }

    public function onDispatchRegisterListeners(MvcEvent $e)
    {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $eventManager = $application->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        foreach (self::$listeners as $listener) {
            $sharedEventManager->attachAggregate($serviceManager->get($listener));
        }
        /**
         * @var $service \FeatureFlags\Service
         */
        $service = $e->getApplication()->getServiceManager()->get(Service::class);
        if ($service->isEnabled('separate-mails-from-notifications')) {
            $sharedEventManager->attachAggregate($serviceManager->get(MailmanWorkerListener::class));
        } else {
            $sharedEventManager->attachAggregate($serviceManager->get(NotificationWorkerListener::class));
        }

        if ($e->getRequest() instanceof Request) {
            /* @var $moduleOptions Options\ModuleOptions */
            $moduleOptions = $serviceManager->get('Mailman\Options\ModuleOptions');
            $uri = new Http($moduleOptions->getLocation());
            $serviceManager->get('HttpRouter')->setRequestUri($uri);

            $moduleOptions = $serviceManager->get('Mailman\Options\ModuleOptions');
            $serverUrlHelper = $serviceManager->get('ViewHelperManager')->get('serverUrl');
            $this->injectServerUrl($serverUrlHelper, $moduleOptions);
            $serverUrlHelper = $serviceManager->get('ZfcTwigViewHelperManager')->get('serverUrl');
            $this->injectServerUrl($serverUrlHelper, $moduleOptions);
        }
    }

    /**
     * @param ServerUrl $serverUrlHelper
     * @param ModuleOptions $moduleOptions
     */
    protected function injectServerUrl(ServerUrl $serverUrlHelper, ModuleOptions $moduleOptions)
    {
        $options = parse_url($moduleOptions->getLocation());
        $serverUrlHelper->setScheme($options['scheme']);
        $serverUrlHelper->setHost($options['host']);
    }
}
