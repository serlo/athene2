<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Navigation\Factory;

use Zend\Mvc\ApplicationInterface;
use Zend\Mvc\Router\RouteMatch;
use Zend\Navigation\Service\AbstractNavigationFactory as ZendAbstractNavigationFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AbstractNavigationFactory
 * Works, even if no RouteMatch is returned by the Application.
 *
 * @package Navigation\Factory
 */
abstract class AbstractNavigationFactory extends ZendAbstractNavigationFactory
{
    /**
     * @var RouteMatch
     */
    protected $routeMatch;

    /**
     * @param ApplicationInterface $application
     * @return RouteMatch
     */
    public function getRouteMatch(ApplicationInterface $application)
    {
        if (!is_object($this->routeMatch)) {
            if (is_object($application->getMvcEvent()->getRouteMatch())) {
                $this->setRouteMatch($application->getMvcEvent()->getRouteMatch());
            } else {
                $this->setRouteMatch(new RouteMatch([]));
            }
        }
        return $this->routeMatch;
    }

    /**
     * @param RouteMatch $routeMatch
     */
    public function setRouteMatch(RouteMatch $routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    /**
     * @param ServiceLocatorInterface   $serviceLocator
     * @param array|\Zend\Config\Config $pages
     * @return mixed
     */
    protected function preparePages(ServiceLocatorInterface $serviceLocator, $pages)
    {
        $application = $serviceLocator->get('Application');
        $routeMatch  = $this->getRouteMatch($application);
        $router      = $application->getMvcEvent()->getRouter();

        return $this->injectComponents($pages, $routeMatch, $router);
    }
}
