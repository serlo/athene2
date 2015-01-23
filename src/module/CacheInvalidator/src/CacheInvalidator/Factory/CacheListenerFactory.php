<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Jakob Pfab (jakob.pfab@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace CacheInvalidator\Factory;

use CacheInvalidator\Listener\CacheListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CacheListenerFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options            = $serviceLocator->get('CacheInvalidator\Options\CacheOptions');
        $invalidatorManager = $serviceLocator->get('CacheInvalidator\Invalidator\InvalidatorManager');
        return new CacheListener($options, $invalidatorManager);
    }
}
