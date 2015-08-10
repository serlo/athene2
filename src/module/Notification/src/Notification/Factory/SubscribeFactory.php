<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Notification\Factory;

use Notification\View\Helper\Subscribe;
use User\Factory\UserManagerFactoryTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SubscribeFactory implements FactoryInterface
{
    use UserManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator      = $serviceLocator->getServiceLocator();
        $userManager         = $this->getUserManager($serviceLocator);
        $subscriptionManager = $serviceLocator->get('Notification\SubscriptionManager');
        return new Subscribe($userManager, $subscriptionManager);
    }
}
