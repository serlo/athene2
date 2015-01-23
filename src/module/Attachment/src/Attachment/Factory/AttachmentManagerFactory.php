<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Attachment\Factory;


use Attachment\Manager\AttachmentManager;
use ClassResolver\ClassResolverFactoryTrait;
use Common\Factory\AuthorizationServiceFactoryTrait;
use Common\Factory\EntityManagerFactoryTrait;
use Instance\Factory\InstanceManagerFactoryTrait;
use Type\Factory\TypeManagerFactoryTrait;
use Uuid\Factory\UuidManagerFactoryTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AttachmentManagerFactory implements FactoryInterface
{
    use ClassResolverFactoryTrait, EntityManagerFactoryTrait;
    use InstanceManagerFactoryTrait;
    use TypeManagerFactoryTrait, AuthorizationServiceFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return AttachmentManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $moduleOptions */
        $moduleOptions   = $serviceLocator->get('Attachment\Options\ModuleOptions');
        $authService     = $this->getAuthorizationService($serviceLocator);
        $classResolver   = $this->getClassResolver($serviceLocator);
        $entityManager   = $this->getEntityManager($serviceLocator);
        $instanceManager = $this->getInstanceManager($serviceLocator);
        $typeManager     = $this->getTypeManager($serviceLocator);
        $instance        = new AttachmentManager($authService, $classResolver, $instanceManager, $moduleOptions, $typeManager, $entityManager);

        return $instance;
    }

}
