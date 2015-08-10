<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Common\Traits;

use Zend\Mvc\Router\RouteInterface;

trait RouterAwareTrait
{

    /**
     * @var RouteInterface
     */
    protected $router;

    /**
     * @return RouteInterface $router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param RouteInterface $router
     * @return void
     */
    public function setRouter(RouteInterface $router)
    {
        $this->router = $router;
    }
}
