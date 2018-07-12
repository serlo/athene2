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
        try {
            $mailChimp = $serviceLocator->get('Newsletter\MailChimp');
        } catch (\Throwable $e) {
            $mailChimp = null;
        }

        return new UserControllerListener($mailChimp);
    }
}
