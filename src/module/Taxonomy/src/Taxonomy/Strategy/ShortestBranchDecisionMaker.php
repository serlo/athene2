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

class ShortestBranchDecisionMaker implements BranchDecisionMakerStrategy
{
    /**
     * @param Collection|TaxonomyTermInterface[] $collection
     * @return TaxonomyTermInterface|null
     */
    public function findBranch(Collection $collection)
    {
        if (empty($collection)) {
            return null;
        }

        $maxDepth = 9999;
        $item     = $collection->first();
        foreach ($collection as $term) {
            $depth = $this->iterBranch($term, $maxDepth);
            if ($depth < $maxDepth) {
                $maxDepth = $depth;
                $item     = $term;
            }
        }
        return $item;
    }

    protected function iterBranch(TaxonomyTermInterface $term, $maxDepth)
    {
        $currDepth = 0;
        while ($term->hasParent()) {
            if ($term->isTrashed()) {
                return $maxDepth;
            }

            $term = $term->getParent();
            $currDepth++;

            if ($currDepth >= $maxDepth) {
                return $currDepth;
            }
        }
        return $currDepth;
    }
}
