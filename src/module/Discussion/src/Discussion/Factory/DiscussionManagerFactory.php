<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Discussion\Factory;

use Authentication\Factory\AuthenticationServiceFactoryTrait;
use ClassResolver\ClassResolverFactoryTrait;
use Common\Factory\AuthorizationServiceFactoryTrait;
use Common\Factory\EntityManagerFactoryTrait;
use Discussion\DiscussionManager;
use Taxonomy\Factory\TaxonomyManagerFactoryTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DiscussionManagerFactory implements FactoryInterface
{
    use AuthorizationServiceFactoryTrait, ClassResolverFactoryTrait, TaxonomyManagerFactoryTrait,
        EntityManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return DiscussionManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authorizationService = $this->getAuthorizationService($serviceLocator);
        $classResolver        = $this->getClassResolver($serviceLocator);
        $objectManager        = $this->getEntityManager($serviceLocator);
        $discussionManager    = new DiscussionManager($authorizationService, $classResolver, $objectManager);
        return $discussionManager;
    }
}
