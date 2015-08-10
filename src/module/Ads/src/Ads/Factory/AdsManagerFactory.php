<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Ads\Factory;


use Ads\Manager\AdsManager;
use ClassResolver\ClassResolverFactoryTrait;
use Common\Factory\AuthorizationServiceFactoryTrait;
use Common\Factory\EntityManagerFactoryTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdsManagerFactory implements FactoryInterface
{
    use EntityManagerFactoryTrait, ClassResolverFactoryTrait, AuthorizationServiceFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authorizationService = $this->getAuthorizationService($serviceLocator);
        $entityManager        = $this->getEntityManager($serviceLocator);
        $classResolver        = $this->getClassResolver($serviceLocator);
        $attachmentManager    = $serviceLocator->get('Attachment\Manager\AttachmentManager');
        $pageManager = $serviceLocator->get('Page\Manager\PageManager');
        $adsManager           = new AdsManager($authorizationService, $attachmentManager, $classResolver, $entityManager,$pageManager);

        return $adsManager;
    }
}
