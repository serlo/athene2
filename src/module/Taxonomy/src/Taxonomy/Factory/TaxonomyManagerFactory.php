<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Taxonomy\Factory;

use ClassResolver\ClassResolverFactoryTrait;
use Common\Factory\AuthorizationServiceFactoryTrait;
use Common\Factory\EntityManagerFactoryTrait;
use Instance\Factory\InstanceManagerFactoryTrait;
use Taxonomy\Manager\TaxonomyManager;
use Taxonomy\Options\ModuleOptions;
use Type\Factory\TypeManagerFactoryTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TaxonomyManagerFactory implements FactoryInterface
{
    use ClassResolverFactoryTrait, EntityManagerFactoryTrait;
    use TypeManagerFactoryTrait, AuthorizationServiceFactoryTrait;
    use InstanceManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $moduleOptions ModuleOptions */
        $authorizationService = $this->getAuthorizationService($serviceLocator);
        $classResolver        = $this->getClassResolver($serviceLocator);
        $objectManager        = $this->getEntityManager($serviceLocator);
        $typeManager          = $this->getTypeManager($serviceLocator);
        $instanceManager      = $this->getInstanceManager($serviceLocator);
        $moduleOptions        = $serviceLocator->get('Taxonomy\Options\ModuleOptions');
        $service              = new TaxonomyManager($authorizationService, $classResolver, $moduleOptions, $instanceManager, $objectManager, $typeManager);
        return $service;
    }
}
