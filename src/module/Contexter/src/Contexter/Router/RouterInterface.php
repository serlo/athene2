<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Contexter\Router;

use Contexter\Adapter\AdapterInterface;
use Zend\Mvc\Router\RouteMatch;

interface RouterInterface
{

    /**
     * @param string $url
     * @param string $type
     * @return RouteMatchInterface[]
     */
    public function match($url = null, $type = null);

    /**
     * @return AdapterInterface
     */
    public function getAdapter();

    /**
     * @param string $uri
     * @return RouteMatch
     */
    public function matchUri($uri);

    /**
     * @param RouteMatch $routeMatch
     * @return self
     */
    public function setRouteMatch(RouteMatch $routeMatch);

    /**
     * @return bool
     */
    public function hasAdapter();
}
