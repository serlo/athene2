<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
