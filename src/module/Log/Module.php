<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Log;

use Zend\EventManager\Event;
use Zend\Mvc\MvcEvent;

class Module
{
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
        $application    = $e->getApplication();
        $serviceLocator = $application->getServiceManager();
        $application->getEventManager()->attach(
            MvcEvent::EVENT_DISPATCH_ERROR,
            function (Event $e) use ($serviceLocator) {
                $exception = $e->getParam('exception');
                $serviceLocator->get('Zend\Log\Logger')->crit($exception);
            }
        );
        $application->getEventManager()->attach(
            MvcEvent::EVENT_RENDER_ERROR,
            function (Event $e) use ($serviceLocator) {
                $exception = $e->getParam('exception');
                $serviceLocator->get('Zend\Log\Logger')->crit($exception);
            }
        );
    }
}
