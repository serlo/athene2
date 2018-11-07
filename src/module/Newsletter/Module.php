<?php
namespace Newsletter;

use Exception;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;

class Module
{
    public static $listeners = [
        'Newsletter\Listener\UserControllerListener',
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
    }
}
