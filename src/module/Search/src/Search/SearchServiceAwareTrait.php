<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Search;

trait SearchServiceAwareTrait
{

    /**
     * @var SearchServiceInterface
     */
    protected $searchService;

    /**
     * @return SearchServiceInterface $searchService
     */
    public function getSearchService()
    {
        return $this->searchService;
    }

    /**
     * @param SearchServiceInterface $searchService
     * @return self
     */
    public function setSearchService(SearchServiceInterface $searchService)
    {
        $this->searchService = $searchService;
        return $this;
    }
}
