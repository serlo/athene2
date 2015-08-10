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

use Authorization\Assertion\RequestInstanceAssertion;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RequestInstanceAssertionFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator    = $serviceLocator->getServiceLocator();
        $instanceManager   = $serviceLocator->get('Instance\Manager\InstanceManager');
        $permissionService = $serviceLocator->get('Authorization\Service\PermissionService');
        $traversalStrategy = $serviceLocator->get('Rbac\Rbac')->getTraversalStrategy();
        $instance          = new RequestInstanceAssertion($instanceManager, $permissionService, $traversalStrategy);

        return $instance;
    }
}
