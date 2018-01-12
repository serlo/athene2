<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.11.2017
 * Time: 17:22
 */

namespace Markdown\Factory;

use Markdown\Service\OryRenderService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OryRenderServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('Markdown\Options\ModuleOptions');
        $storage = $serviceLocator->get('Markdown\Storage\MarkdownStorage');
        $service = new OryRenderService($options, $storage);

        return $service;
    }
}
