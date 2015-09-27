<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Jonas Keinholz (jonas.keinholz@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Instance\Factory;

use Instance\View\Helper\LanguageHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LanguageHelperFactory implements FactoryInterface
{
    use InstanceManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator  = $serviceLocator->getServiceLocator();
        $instanceManager = $this->getInstanceManager($serviceLocator);
        $instance        = new LanguageHelper($instanceManager);

        return $instance;
    }
}
