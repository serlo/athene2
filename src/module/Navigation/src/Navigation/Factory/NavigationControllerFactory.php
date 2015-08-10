<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Navigation\Factory;

use Instance\Factory\InstanceManagerFactoryTrait;
use Navigation\Controller\NavigationController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NavigationControllerFactory implements FactoryInterface
{
    use NavigationManagerFactoryTrait, InstanceManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator ServiceLocatorInterface */
        $serviceLocator    = $serviceLocator->getServiceLocator();
        $containerForm     = $serviceLocator->get('Navigation\Form\ContainerForm');
        $pageForm          = $serviceLocator->get('Navigation\Form\PageForm');
        $parameterForm     = $serviceLocator->get('Navigation\Form\ParameterForm');
        $parameterKeyForm  = $serviceLocator->get('Navigation\Form\ParameterKeyForm');
        $navigationManager = $this->getNavigationManager($serviceLocator);
        $instanceManager   = $this->getInstanceManager($serviceLocator);
        $controller        = new NavigationController($instanceManager, $navigationManager, $containerForm, $pageForm, $parameterForm, $parameterKeyForm);

        return $controller;
    }
}
