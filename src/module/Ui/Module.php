<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
namespace Ui;

use Zend\EventManager\Event;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;


class Module
{

    public function getAutoloaderConfig()
    {
        if (file_exists(__DIR__ . '/autoload_classmap.php')) {
            return [
                'Zend\Loader\ClassMapAutoloader' => [
                    __DIR__ . '/autoload_classmap.php',
                ]
            ];
        } else {
            return [
                'Zend\Loader\StandardAutoloader' => [
                    'namespaces' => [
                        __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                    ]
                ]
            ];
        }
    }

    public function getConfig()
    {
        $config = include __DIR__ . '/config/module.config.php';

        if (file_exists(__DIR__ . '/template_map.php')) {
            $templates                 = [];
            $templates['view_manager'] = [
                'template_map' => include __DIR__ . '/template_map.php'
            ];

            return ArrayUtils::merge($config, $templates);
        }

        $config['view_manager']['template_path_stack'] = [
            __DIR__ . '/templates'
        ];

        return $config;
    }

    public function onBootstrap(MvcEvent $e)
    {
        $application  = $e->getApplication();
        $eventManager = $application->getEventManager();
        $eventManager->getSharedManager()->attach(
            'Zend\Mvc\Controller\AbstractController',
            MvcEvent::EVENT_DISPATCH,
            array($this, 'onDispatch'),
            -1000
        );
    }

    public function onDispatch(Event $e)
    {
        $controller     = $e->getTarget();
        $serviceManager = $controller->getServiceLocator();
        $container      = $serviceManager->get('default_navigation');

        // If no active navigation is found, we revert to 1-col layout
        foreach ($container as $page) {
            if ($page->isVisible(false) && $page->isActive(true)) {
                // At least one item is active, nothing to do.
                return;
            }
        }

        if($e->getViewModel()->getTemplate() == 'layout/layout'){
            $controller->layout('layout/1-col');
        }
    }
}
