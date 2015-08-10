<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Contexter\Adapter;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Router\RouteMatch;

interface AdapterInterface
{

    /**
     * @return array
     */
    public function getProvidedParams();

    /**
     * @return array
     */
    public function getRouteParams();

    /**
     * @return array
     */
    public function getParams();

    /**
     * @return array
     */
    public function getKeys();

    /**
     * @return AbstractActionController
     */
    public function getAdaptee();

    /**
     * @param RouteMatch $routeMatch
     * @return self
     */
    public function setRouteMatch(RouteMatch $routeMatch);

    /**
     * @param AdaptableInterface $adapter
     * @return self
     */
    public function setAdaptee($adapter);
}
