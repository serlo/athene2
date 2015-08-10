<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Factory;

use ClassResolver\ClassResolverFactoryTrait;
use Common\Factory\AuthorizationServiceFactoryTrait;
use Common\Factory\EntityManagerFactoryTrait;
use Instance\Factory\InstanceManagerFactoryTrait;
use RelatedContent\Manager\RelatedContentManager;
use Uuid\Factory\UuidManagerFactoryTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RelatedContentManagerFactory implements FactoryInterface
{
    use ClassResolverFactoryTrait, UuidManagerFactoryTrait;
    use EntityManagerFactoryTrait, AuthorizationServiceFactoryTrait;
    use InstanceManagerFactoryTrait;

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $classResolver        = $this->getClassResolver($serviceLocator);
        $authorizationService = $this->getAuthorizationService($serviceLocator);
        $uuidManager          = $this->getUuidManager($serviceLocator);
        $objectManager        = $this->getEntityManager($serviceLocator);
        $router               = $serviceLocator->get('router');
        $instanceManager      = $this->getInstanceManager($serviceLocator);
        $instance             = new RelatedContentManager($authorizationService, $classResolver, $instanceManager, $router, $objectManager, $uuidManager);

        return $instance;
    }
}
