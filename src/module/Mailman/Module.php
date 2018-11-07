<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Mailman;

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
        'Mailman\Listener\NotificationWorkerListener',
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
        $eventManager       = $e->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();
        foreach (self::$listeners as $listener) {
            $sharedEventManager->attachAggregate(
                $e->getApplication()->getServiceManager()->get($listener)
            );
        }

        $application        = $e->getApplication();
        $serviceLocator     = $application->getServiceManager();
        if ($e->getRequest() instanceof Request) {
            /* @var $moduleOptions Options\ModuleOptions */
            $moduleOptions = $serviceLocator->get('Mailman\Options\ModuleOptions');
            $uri           = new Http($moduleOptions->getLocation());
            $serviceLocator->get('HttpRouter')->setRequestUri($uri);

            $moduleOptions = $serviceLocator->get('Mailman\Options\ModuleOptions');
            $serverUrlHelper = $serviceLocator->get('ViewHelperManager')->get('serverUrl');
            $this->injectServerUrl($serverUrlHelper, $moduleOptions);
            $serverUrlHelper = $serviceLocator->get('ZfcTwigViewHelperManager')->get('serverUrl');
            $this->injectServerUrl($serverUrlHelper, $moduleOptions);
        }
    }

    /**
     * @param ServerUrl     $serverUrlHelper
     * @param ModuleOptions $moduleOptions
     */
    protected function injectServerUrl(ServerUrl $serverUrlHelper, ModuleOptions $moduleOptions)
    {
        $options = parse_url($moduleOptions->getLocation());
        $serverUrlHelper->setScheme($options['scheme']);
        $serverUrlHelper->setHost($options['host']);
    }
}
