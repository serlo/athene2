<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.12.2017
 * Time: 16:37
 */

namespace Markdown\Factory;

use Markdown\View\Helper\MarkdownHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OryRenderHelperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $renderer       = $serviceLocator->get('Markdown\Service\OryRenderService');
        $plugin         = new MarkdownHelper($renderer);

        return $plugin;
    }
}
