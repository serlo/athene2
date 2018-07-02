<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright   Copyright (c) 2013 Gesellschaft f√ºr freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Subject\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Entity\Entity\EntityInterface;
use Instance\Entity\InstanceInterface;
use Normalizer\Normalizer;
use Taxonomy\Entity\TaxonomyTermInterface;
use Taxonomy\Manager\TaxonomyManagerAwareTrait;
use Taxonomy\Manager\TaxonomyManagerInterface;
use Zend\Cache\Storage\StorageInterface;

class SubjectManager implements SubjectManagerInterface
{
    use TaxonomyManagerAwareTrait;

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var Normalizer
     */
    protected $normalizer;

    public function __construct(
        Normalizer $normalizer,
        StorageInterface $storage,
        TaxonomyManagerInterface $taxonomyManager
    ) {
        $this->taxonomyManager = $taxonomyManager;
        $this->storage         = $storage;
        $this->normalizer      = $normalizer;
    }

    public function findSubjectByString($name, InstanceInterface $instance)
    {
        $taxonomy = $this->getTaxonomyManager()->findTaxonomyByName('subject', $instance);
        $term     = $this->getTaxonomyManager()->findTermByName($taxonomy, (array)$name);
        return $term;
    }

    public function findSubjectsByInstance(InstanceInterface $instance)
    {
        $taxonomy = $this->getTaxonomyManager()->findTaxonomyByName('subject', $instance);
        return $taxonomy->getChildren();
    }

    public function getSubject($id)
    {
        $term = $this->getTaxonomyManager()->getTerm($id);
        return $term;
    }

    public function getTrashedEntities(TaxonomyTermInterface $term)
    {
        $key = 'trashed:' .hash('sha256', serialize($term));
        if ($this->storage->hasItem($key)) {
            return $this->storage->getItem($key);
        }

        $entities   = $this->getEntities($term);
        $collection = new ArrayCollection();
        $this->iterEntities($entities, $collection, 'isTrashed');
        $this->storage->setItem($key, $collection);
        return $collection;
    }

    public function getUnrevisedRevisions(TaxonomyTermInterface $term)
    {
        $key = 'unrevised:' . hash('sha256', serialize($term));
        if ($this->storage->hasItem($key)) {
            return $this->storage->getItem($key);
        }

        $entities   = $this->getEntities($term);
        $collection = new ArrayCollection();
        $this->iterEntities($entities, $collection, 'isRevised');
        $iterator = $collection->getIterator();
        $iterator->ksort();
        $collection = new ArrayCollection(iterator_to_array($iterator));
        $this->storage->setItem($key, $collection);
        return $collection;
    }

    protected function getEntities(TaxonomyTermInterface $term)
    {
        return $term->getAssociatedRecursive('entities');
    }

    protected function isRevised(EntityInterface $entity, Collection $collection)
    {
        if ($entity->isUnrevised() && !$collection->contains($entity)) {
            $normalized = $this->normalizer->normalize($entity->getHead());
            $collection->set(-$normalized->getMetadata()->getCreationDate()->getTimestamp(), $normalized);
        }
    }

    protected function isTrashed(EntityInterface $entity, Collection $collection)
    {
        if ($entity->getTrashed()) {
            // Todo undirtify, this is needed because we can't cache doctrine models (where are your proxies now?)
            $normalized = $this->normalizer->normalize($entity);
            $collection->add($normalized);
        }
    }

    protected function iterEntities(Collection $entities, Collection $collection, $callback)
    {
        foreach ($entities as $entity) {
            // Todo undirtify, this is needed because we can't cache doctrine models (where are your proxies now?)
            $this->$callback($entity, $collection);
            $this->iterLinks($entity, $collection, $callback);
        }
    }

    protected function iterLinks(EntityInterface $entity, $collection, $callback)
    {
        $this->iterEntities($entity->getChildren('link'), $collection, $callback);
    }
}
