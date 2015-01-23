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

use Authentication\Controller\AuthenticationController;
use User\Factory\UserManagerFactoryTrait;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationControllerFactory implements FactoryInterface
{

    use AuthenticationServiceFactoryTrait, UserManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return AuthenticationController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator AbstractPluginManager */
        $serviceManager        = $serviceLocator->getServiceLocator();
        $authenticationService = $this->getAuthenticationService($serviceManager);
        $userManager           = $this->getUserManager($serviceManager);
        $roleService           = $serviceManager->get('Authorization\Service\RoleService');
        $controller            = new AuthenticationController($authenticationService, $roleService, $userManager);

        return $controller;
    }
}
