<?php
namespace Newsletter\Factory;

use Newsletter\Listener\UserControllerListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserControllerListenerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return UserControllerListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $mailChimp = $serviceLocator->get('\DrewM\MailChimp\MailChimp');

        return new UserControllerListener($mailChimp);
    }
}
