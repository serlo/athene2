<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Search\Factory;

use Search\SearchService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SearchServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $pluginManager         = $serviceLocator->get('Search\Adapter\AdapterPluginManager');
        $providerPluginManager = $serviceLocator->get('Search\Provider\ProviderPluginManager');
        $options               = $serviceLocator->get('Search\Options\ModuleOptions');
        $adapter               = $pluginManager->get($options->getAdapter());
        $instance              = new SearchService($adapter, $options, $providerPluginManager);
        return $instance;
    }
}
