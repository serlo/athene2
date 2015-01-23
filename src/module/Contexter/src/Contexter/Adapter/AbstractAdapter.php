<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Contexter\Adapter;

use Contexter\Exception\RuntimeException;
use Contexter\Router\RouterAwareTrait;
use Zend\Mvc\Router\RouteMatch;
use Zend\Stdlib\ArrayUtils;

abstract class AbstractAdapter implements AdapterInterface
{
    use RouterAwareTrait;

    /**
     * @var RouteMatch
     */
    protected $routeMatch;

    /**
     * @var AdaptableInterface
     */
    protected $adapter;

    public function getAdaptee()
    {
        return $this->adapter;
    }

    public function setAdaptee($adapter)
    {
        if (!$this->isValidController($adapter)) {
            throw new RuntimEexception(sprintf('Invalid controller type'));
        }
        $this->adapter = $adapter;
    }

    public function getKeys()
    {
        return array_keys($this->getParameters());
    }

    public function getRouteMatch()
    {
        return $this->routeMatch;
    }

    public function setRouteMatch(RouteMatch $routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    public function getRouteParams()
    {
        return $this->getRouteMatch()->getParams();
    }

    public function getParams()
    {
        return ArrayUtils::merge($this->getRouteParams(), $this->getProvidedParams());
    }

    abstract protected function isValidController($controller);
}
