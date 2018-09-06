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
        $storage = $serviceLocator->get('Markdown\Storage\MarkdownStorage');
        $config  = $serviceLocator->get('config');
        $url     = $config['editor_renderer']['url'];

        $service = new OryRenderService($url, $storage);

        return $service;
    }
}
