<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Common\Factory;

use Common\Hydrator\HydratorPluginAwareDoctrineObject;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HydratorPluginAwareDoctrineObjectFactory implements FactoryInterface
{
    use EntityManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $objectManager = $this->getEntityManager($serviceLocator);
        $pluginManager = $serviceLocator->get('Common\Hydrator\HydratorPluginManager');
        $hydrator      = new HydratorPluginAwareDoctrineObject($objectManager, $pluginManager);
        return $hydrator;
    }
}
