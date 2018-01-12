<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\View\Helper;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Entity\Entity\EntityInterface;
use Entity\Entity\RevisionInterface;
use Entity\Exception;
use Entity\Options\ModuleOptionsAwareTrait;
use Zend\View\Helper\AbstractHelper;

class EntityHelper extends AbstractHelper
{
    use ModuleOptionsAwareTrait;

    public function __invoke()
    {
        return $this;
    }

    public function findSubject(EntityInterface $entity) {
        $subject = $this->findTaxonomyTerm($entity, 'subject');
        return $subject ? $subject->getName() : '';
    }

    public function findTaxonomyTerm(EntityInterface $entity, $type)
    {
        /* @var $term \Taxonomy\Entity\TaxonomyTermInterface */
        foreach ($entity->getTaxonomyTerms() as $term) {
            $ancestor = $term->findAncestorByTypeName($type);
            if ($ancestor) {
                return $ancestor;
            }
        }

        return null;
    }

    public function getVisible(Collection $entities)
    {
        return $entities->filter(
            function (EntityInterface $e) {
                if ($this->getView()->isGranted('login')) {
                    $unrevised = ($e->hasHead() && $e->isUnrevised());
                    return !$e->isTrashed() && ($e->hasCurrentRevision() || $unrevised);
                } else {
                    return !$e->isTrashed() && $e->hasCurrentRevision();
                }
            }
        );
    }

    public function asTypeCollection(Collection $entities)
    {
        $types = [];
        foreach ($entities as $e) {
            $types[$e->getType()->getName()][] = $e;
        }

        return new ArrayCollection($types);
    }

    public function getOptions(EntityInterface $entity)
    {
        return $this->getModuleOptions()->getType(
            $entity->getType()->getName()
        );
    }

    public function isOryEditorFormat(RevisionInterface $revision) {
        $parsed = \GuzzleHttp\json_decode($revision->get('content'));
        return $parsed !== null && isset($parsed['cells']);
    }
}
