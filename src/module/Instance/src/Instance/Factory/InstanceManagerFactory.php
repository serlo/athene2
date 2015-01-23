<?php
/**
 * Created by PhpStorm.
 * User: mrnice
 * Date: 15.01.14
 * Time: 01:37
 */
namespace Instance\Factory;

use ClassResolver\ClassResolverFactoryTrait;
use Common\Factory\AuthorizationServiceFactoryTrait;
use Common\Factory\EntityManagerFactoryTrait;
use Instance\Manager\InstanceManager;
use Instance\Options\InstanceOptions;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class InstanceManagerFactory implements FactoryInterface
{
    use EntityManagerFactoryTrait;
    use ClassResolverFactoryTrait;
    use AuthorizationServiceFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options InstanceOptions */
        $options = $serviceLocator->get('Instance\Options\InstanceOptions');
        /* @var $pluginManager AbstractPluginManager */
        $pluginManager        = $serviceLocator->get('Instance\Strategy\StrategyPluginManager');
        $objectManager        = $this->getEntityManager($serviceLocator);
        $classResolver        = $this->getClassResolver($serviceLocator);
        $authorizationService = $this->getAuthorizationService($serviceLocator);
        $strategy             = $pluginManager->get($options->getStrategy());
        $instance             = new InstanceManager($authorizationService, $classResolver, $options, $objectManager, $strategy);

        return $instance;
    }
}
