<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Taxonomy\Factory;

use Taxonomy\View\Helper\TaxonomyHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TaxonomyHelperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator  = $serviceLocator->getServiceLocator();
        $moduleOptions   = $serviceLocator->get('Taxonomy\Options\ModuleOptions');
        $taxonomyManager = $serviceLocator->get('Taxonomy\Manager\TaxonomyManager');
        $plugin          = new TaxonomyHelper($moduleOptions, $taxonomyManager);

        return $plugin;
    }
}
