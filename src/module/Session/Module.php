<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Session;

use Zend\Mvc\MvcEvent;
use Zend\Session\AbstractContainer;
use Zend\Session\SessionManager;

class Module
{

    public function getAutoloaderConfig()
    {
        $autoloader = [];

        $autoloader['Zend\Loader\StandardAutoloader'] = [
            'namespaces' => [
                __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
            ]
        ];

        if (file_exists(__DIR__ . '/autoload_classmap.php')) {
            return [
                'Zend\Loader\ClassMapAutoloader' => [
                    __DIR__ . '/autoload_classmap.php',
                ]
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
        /* @var $sessionManager SessionManager */
        $serviceLocator = $e->getApplication()->getServiceManager();
        $sessionManager = $serviceLocator->get('Zend\Session\SessionManager');
        $sessionManager->setSaveHandler($serviceLocator->get('Zend\Session\SaveHandler\SaveHandlerInterface'));
        AbstractContainer::setDefaultManager($sessionManager);
    }
}
