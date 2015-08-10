<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Taxonomy\Manager;

trait TaxonomyManagerAwareTrait
{

    /**
     * @var TaxonomyManagerInterface
     */
    protected $taxonomyManager;

    /**
     * @return TaxonomyManagerInterface
     *         $termManager
     */
    public function getTaxonomyManager()
    {
        return $this->taxonomyManager;
    }

    /**
     * @param TaxonomyManagerInterface $termManager
     * @return self
     */
    public function setTaxonomyManager(TaxonomyManagerInterface $termManager)
    {
        $this->taxonomyManager = $termManager;
        return $this;
    }
}
