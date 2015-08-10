<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */

namespace Taxonomy\Strategy;

use Doctrine\Common\Collections\Collection;
use Taxonomy\Entity\TaxonomyTermInterface;

interface BranchDecisionMakerStrategy
{

    /**
     * @param Collection|TaxonomyTermInterface[] $collection
     * @return TaxonomyTermInterface|null
     */
    public function findBranch(Collection $collection);
}
