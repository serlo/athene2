<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Instance\Strategy;

use Instance\Entity\InstanceInterface;
use Instance\Exception;
use Instance\Manager\InstanceManagerInterface;
use Zend\Mvc\Router\RouteInterface;
use Zend\Mvc\Router\RouteMatch;
use Zend\Stdlib\ResponseInterface;

class DomainStrategy extends AbstractStrategy
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var RouteInterface
     */
    protected $router;

    /**
     * @var RouteMatch
     */
    protected $routeMatch;

    /**
     * @var InstanceInterface
     */
    protected $instance;

    /**
     * @param ResponseInterface $response
     * @param RouteInterface    $router
     * @param RouteMatch        $routeMatch
     */
    public function __construct(ResponseInterface $response, RouteInterface $router, RouteMatch $routeMatch)
    {
        $this->response   = $response;
        $this->routeMatch = $routeMatch;
        $this->router     = $router;
    }

    /**
     * {@inheritDoc}
     */
    public function getActiveInstance(InstanceManagerInterface $instanceManager)
    {
        if (!array_key_exists('HTTP_HOST', (array)$_SERVER)) {
            return $instanceManager->getDefaultInstance();
        }

        if (!is_object($this->instance)) {
            $subDomain      = explode('.', $_SERVER['HTTP_HOST'])[0];
            $this->instance = $instanceManager->findInstanceBySubDomain($subDomain);
        }

        return $this->instance;
    }

    /**
     * {@inheritDoc}
     */
    public function switchInstance(InstanceInterface $instance)
    {
        if (!array_key_exists('HTTP_HOST', (array)$_SERVER)) {
            throw new Exception\RuntimeException(sprintf('Host not set.'));
        }

        $url = $this->router->assemble(
            $this->routeMatch->getParams(),
            [
                'name' => $this->routeMatch->getMatchedRouteName()
            ]
        );

        $hostNames = explode('.', $_SERVER['HTTP_HOST']);
        $tld       = $hostNames[count($hostNames) - 2] . "." . $hostNames[count($hostNames) - 1];
        $url = 'http://' . $instance->getSubdomain() . '.' . $tld . $url;

        $this->redirect($url);
    }
}
