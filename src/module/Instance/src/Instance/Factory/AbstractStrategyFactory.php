<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Instance\Factory;

use Zend\Mvc\Router\RouteMatch;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractStrategyFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator AbstractPluginManager */
        $serviceManager = $serviceLocator->getServiceLocator();
        $response       = $serviceManager->get('Response');
        $request        = $serviceManager->get('Request');
        $router         = $serviceManager->get('Router');
        $routeMatch     = $router->match($request);
        $class          = $this->getClass();

        if (null === $routeMatch) {
            $routeMatch = new RouteMatch([]);
            $routeMatch->setMatchedRouteName('home');
        }

        return new $class($response, $router, $routeMatch);
    }

    abstract protected function getClass();
}
