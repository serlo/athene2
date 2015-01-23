<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Taxonomy\Entity;

use Doctrine\Common\Collections\Collection;

interface TaxonomyTermAwareInterface
{
    /**
     * @param TaxonomyTermInterface     $taxonomyTerm
     * @param TaxonomyTermNodeInterface $node
     * @return self
     */
    public function addTaxonomyTerm(TaxonomyTermInterface $taxonomyTerm, TaxonomyTermNodeInterface $node = null);

    /**
     * @return int
     */
    public function getId();

    /**
     * @return TaxonomyTermInterface[]|Collection
     */
    public function getTaxonomyTerms();

    /**
     * @param TaxonomyTermInterface     $taxonomyTerm
     * @param TaxonomyTermNodeInterface $node
     * @return self
     */
    public function removeTaxonomyTerm(TaxonomyTermInterface $taxonomyTerm, TaxonomyTermNodeInterface $node = null);
}
