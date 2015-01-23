<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
