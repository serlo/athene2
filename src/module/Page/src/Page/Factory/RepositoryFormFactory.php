<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Page\Factory;

use ClassResolver\ClassResolverFactoryTrait;
use Common\Factory\EntityManagerFactoryTrait;
use Page\Form\RepositoryForm;
use Taxonomy\Factory\TaxonomyManagerFactoryTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RepositoryFormFactory implements FactoryInterface
{
    use EntityManagerFactoryTrait, ClassResolverFactoryTrait, TaxonomyManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $entityManager   = $this->getEntityManager($serviceLocator);
        $page            = $this->getClassResolver($serviceLocator)->resolve('Page\Entity\PageRepositoryInterface');
        $taxonomyManager = $this->getTaxonomyManager($serviceLocator);
        return new RepositoryForm($entityManager, $page, $taxonomyManager);
    }
}
