<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Taxonomy\Manager;

use Common\ObjectManager\Flushable;
use Doctrine\Common\Collections\Collection;
use Instance\Entity\InstanceInterface;
use Taxonomy\Entity\TaxonomyInterface;
use Taxonomy\Entity\TaxonomyTermAwareInterface;
use Taxonomy\Entity\TaxonomyTermInterface;
use Taxonomy\Form\TermForm;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\Form\FormInterface;

interface TaxonomyManagerInterface extends Flushable, EventManagerAwareInterface
{
    /**
     * @param int|TaxonomyTermInterface  $term
     * @param TaxonomyTermAwareInterface $with
     * @param int|null                   $position
     * @return self
     */
    public function associateWith($term, TaxonomyTermAwareInterface $with, $position = null);

    /**
     * @param TermForm $termForm
     * @return TaxonomyTermInterface
     */
    public function createRoot(TermForm $termForm);

    /**
     * @param FormInterface $form
     * @return mixed
     */
    public function createTerm(FormInterface $form);

    /**
     * @param bool $bypassInstanceIsolation
     * @return TaxonomyTermInterface[]|Collection
     */
    public function findAllTerms($bypassInstanceIsolation = false);

    /**
     * @param string            $name
     * @param InstanceInterface $instance
     * @return TaxonomyInterface
     */
    public function findTaxonomyByName($name, InstanceInterface $instance);

    /**
     * @param InstanceInterface $instance
     * @return TaxonomyInterface[]
     */
    public function findAllTaxonomies(InstanceInterface $instance);

    /**
     * @param TaxonomyInterface $taxonomy
     * @param array             $ancestors
     * @return TaxonomyTermInterface
     */
    public function findTermByName(TaxonomyInterface $taxonomy, array $ancestors);

    /**
     * @param int $id
     * @return TaxonomyInterface
     */
    public function getTaxonomy($id);

    /**
     * @param int $id
     * @return TaxonomyTermInterface
     */
    public function getTerm($id);

    /**
     * @param int|TaxonomyTermInterface  $term
     * @param TaxonomyTermAwareInterface $object
     * @return mixed
     */
    public function isAssociableWith($term, TaxonomyTermAwareInterface $object);

    /**
     * @param int                        $id
     * @param TaxonomyTermAwareInterface $object
     * @return self
     */
    public function removeAssociation($id, TaxonomyTermAwareInterface $object);

    /**
     * @param FormInterface $form
     * @return mixed
     */
    public function updateTerm(FormInterface $form);
}
