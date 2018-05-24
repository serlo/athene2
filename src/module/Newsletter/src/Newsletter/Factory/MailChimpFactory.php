<?php
namespace Newsletter\Factory;

use \DrewM\MailChimp\MailChimp;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MailChimpFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return MailChimp
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $apiKey = $config['newsletter_options']['api_key'];
        return new MailChimp($apiKey);
    }
}
