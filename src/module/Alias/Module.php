<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Alias;

use Exception;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;
use Zend\Mvc\MvcEvent;

class Module
{

    public static $listeners = [
        'Alias\Listener\BlogManagerListener',
        'Alias\Listener\PageControllerListener',
        'Alias\Listener\RepositoryManagerListener',
        'Alias\Listener\TaxonomyManagerListener'
    ];

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
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatch'), 1000);
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onDispatchRegisterListeners'), 1000);
    }

    public function onDispatch(MvcEvent $e)
    {
        $application    = $e->getApplication();
        $response       = $e->getResponse();
        $request        = $application->getRequest();
        $serviceManager = $application->getServiceManager();
        /* @var $aliasManager AliasManagerInterface */
        $aliasManager    = $serviceManager->get('Alias\AliasManager');
        $instanceManager = $serviceManager->get('Instance\Manager\InstanceManager');

        if (!($response instanceof HttpResponse && $request instanceof HttpRequest)) {
            return null;
        }

        /* @var $uriClone \Zend\Uri\Http */
        $uriClone = clone $request->getUri();
        $uri      = $uriClone->getPath();
        $query = $uriClone->getQuery();

        try {
            $location = $aliasManager->findAliasBySource($uri, $instanceManager->getInstanceFromRequest());
        } catch (Exception $ex) {
            return null;
        }

        if ($query) {
            $location .= '?' . $query;
        }

        $response->getHeaders()->addHeaderLine('Location', $location);
        $response->setStatusCode(301);
        $response->sendHeaders();
        $e->stopPropagation();
        return $response;
    }

    public function onDispatchError(MvcEvent $e)
    {
        $application    = $e->getApplication();
        $response       = $e->getResponse();
        $request        = $application->getRequest();
        $serviceManager = $application->getServiceManager();
        /* @var $aliasManager AliasManagerInterface */
        $aliasManager    = $serviceManager->get('Alias\AliasManager');
        $instanceManager = $serviceManager->get('Instance\Manager\InstanceManager');
        if (!($response instanceof HttpResponse && $request instanceof HttpRequest)) {
            return null;
        }

        /* @var $uriClone \Zend\Uri\Http */
        $uriClone = clone $request->getUri();

        try {
            $uri      = $uriClone->makeRelative('/')->getPath();
            $location = $aliasManager->findCanonicalAlias($uri, $instanceManager->getInstanceFromRequest());
        } catch (Exception $ex) {
            return null;
        }

        $response->getHeaders()->addHeaderLine('Location', $location);
        $response->setStatusCode(301);
        $response->sendHeaders();
        $e->stopPropagation();
        return $response;
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
