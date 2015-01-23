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
namespace Authentication\Factory;

use Authentication\Service\AuthenticationService;
use Zend\Mvc\Application;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sessionConfig = $serviceLocator->get('Zend\Session\Config\SessionConfig');
        $request       = $serviceLocator->get('Request');
        $response      = $serviceLocator->get('Response');
        $adapter       = $serviceLocator->get('Authentication\Adapter\UserAuthAdapter');
        $storage       = $serviceLocator->get('Authentication\Storage\UserSessionStorage');
        $instance      = new AuthenticationService($storage, $adapter, $sessionConfig, $response, $request);

        return $instance;
    }

}
