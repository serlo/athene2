<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Authorization\Factory;

use Authorization\Controller\RoleController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $userManager       = $serviceLocator->getServiceLocator()->get('User\Manager\UserManager');
        $permissionService = $serviceLocator->getServiceLocator()->get('Authorization\Service\PermissionService');
        $roleService       = $serviceLocator->getServiceLocator()->get('Authorization\Service\RoleService');
        $instanceManager   = $serviceLocator->getServiceLocator()->get('Instance\Manager\InstanceManager');
        $roleForm          = $serviceLocator->getServiceLocator()->get('Authorization\Form\RoleForm');
        $instance          = new RoleController($instanceManager, $permissionService, $roleService, $userManager, $roleForm);

        return $instance;
    }
}
