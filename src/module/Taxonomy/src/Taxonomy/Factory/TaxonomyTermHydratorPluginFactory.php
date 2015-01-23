<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Taxonomy\Factory;

use Common\Factory\EntityManagerFactoryTrait;
use Taxonomy\Hydrator\TaxonomyTermHydratorPlugin;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TaxonomyTermHydratorPluginFactory implements FactoryInterface
{
    use TaxonomyManagerFactoryTrait, EntityManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator  = $serviceLocator->getServiceLocator();
        $objectManager   = $this->getEntityManager($serviceLocator);
        $taxonomyManager = $this->getTaxonomyManager($serviceLocator);
        $plugin          = new TaxonomyTermHydratorPlugin($objectManager, $taxonomyManager);
        return $plugin;
    }
}
