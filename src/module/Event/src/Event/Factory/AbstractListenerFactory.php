<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Event\Factory;

use Event\Listener\AbstractListener;
use Instance\Factory\InstanceManagerFactoryTrait;
use User\Factory\UserManagerFactoryTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractListenerFactory implements FactoryInterface
{
    use UserManagerFactoryTrait, InstanceManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $listener        = $this->getListenerClassName();
        $eventManager    = $serviceLocator->get('Event\EventManager');
        $userManager     = $this->getUserManager($serviceLocator);
        $instanceManager = $this->getInstanceManager($serviceLocator);

        /* @var $listener AbstractListener */
        $listener = new $listener($eventManager, $instanceManager, $userManager);

        return $listener;
    }

    abstract protected function getListenerClassName();
}
