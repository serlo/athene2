<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license        LGPL-3.0
 * @license        http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Authorization\Factory;

use Authorization\Guard\HydratableControllerGuard;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HydratableControllerGuardFactory implements FactoryInterface, MutableCreationOptionsInterface
{

    /**
     * @var array
     */
    protected $options;

    /**
     * {@inheritDoc}
     */
    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }

    /**t
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        $parentLocator = $serviceLocator->getServiceLocator();

        /* @var \ZfcRbac\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $parentLocator->get('ZfcRbac\Options\ModuleOptions');

        /* @var \ZfcRbac\Service\RoleService $roleService */
        $roleService = $parentLocator->get('ZfcRbac\Service\RoleService');

        $controllerGuard = new HydratableControllerGuard($roleService, $this->options);
        $controllerGuard->setProtectionPolicy($moduleOptions->getProtectionPolicy());
        $controllerGuard->setServiceLocator($parentLocator);

        return $controllerGuard;
    }
}
