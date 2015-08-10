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

use Instance\Factory\InstanceManagerFactoryTrait;
use Search\Adapter\SolrAdapter;
use Uuid\Factory\UuidManagerFactoryTrait;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SolrAdapterFactory implements FactoryInterface
{
    use UuidManagerFactoryTrait, InstanceManagerFactoryTrait;

    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator AbstractPluginManager */
        $serviceManager  = $serviceLocator->getServiceLocator();
        $client          = $serviceManager->get('Solarium\Client');
        $normalizer      = $serviceManager->get('Normalizer\Normalizer');
        $translator      = $serviceManager->get('MvcTranslator');
        $instanceManager = $this->getInstanceManager($serviceManager);
        $uuidManager     = $this->getUuidManager($serviceManager);

        return new SolrAdapter($client, $instanceManager, $normalizer, $translator, $uuidManager);
    }
}
