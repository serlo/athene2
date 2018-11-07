<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Subject\Factory;

use Subject\Manager\SubjectManager;
use Taxonomy\Factory\TaxonomyManagerFactoryTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SubjectManagerFactory implements FactoryInterface
{
    use TaxonomyManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $taxonomyManager = $this->getTaxonomyManager($serviceLocator);
        $storage         = $serviceLocator->get('Subject\Storage\SubjectStorage');
        $normalizer      = $serviceLocator->get('Normalizer\Normalizer');
        $entityManager   = $serviceLocator->get('Entity\Manager\EntityManager');
        $service         = new SubjectManager($normalizer, $storage, $taxonomyManager, $entityManager);

        return $service;
    }
}
