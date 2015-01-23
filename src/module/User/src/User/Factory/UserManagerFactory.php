<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace User\Factory;

use User\Manager\UserManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserManagerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $instance             = new UserManager();
        $objectManager        = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $authService          = $serviceLocator->get('Zend\Authentication\AuthenticationService');
        $classResolver        = $serviceLocator->get('ClassResolver\ClassResolver');
        $hydrator             = $serviceLocator->get('User\Hydrator\UserHydrator');
        $authorizationService = $serviceLocator->get('ZfcRbac\Service\AuthorizationService');

        $instance->setObjectManager($objectManager);
        $instance->setClassResolver($classResolver);
        $instance->setHydrator($hydrator);
        $instance->setAuthenticationService($authService);
        $instance->setAuthorizationService($authorizationService);

        return $instance;
    }

}
