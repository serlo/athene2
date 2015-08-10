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
use Navigation\Provider\ContainerRepositoryProvider;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContainerRepositoryProviderFactory implements FactoryInterface
{
    use InstanceManagerFactoryTrait, NavigationManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $instanceManager   = $this->getInstanceManager($serviceLocator);
        $navigationManager = $this->getNavigationManager($serviceLocator);
        $storage           = $serviceLocator->get('Navigation\Storage\Storage');
        $instance          = new ContainerRepositoryProvider($instanceManager, $navigationManager, $storage);

        return $instance;
    }
}
