<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 07.01.2019
 * Time: 17:32
 */

namespace Mailman\Factory;

use Mailman\Renderer\MailRenderer;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MailRendererFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return MailRenderer
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $renderer = $serviceLocator->get('ZfcTwigRenderer');
        return new MailRenderer($renderer);
    }
}
