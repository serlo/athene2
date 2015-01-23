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
