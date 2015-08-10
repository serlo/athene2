<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Page\Manager;

trait PageManagerAwareTrait
{
    /**
     * @var PageManagerInterface
     */
    protected $pageManager;

    /**
     * @return PageManagerInterface
     */
    public function getPageManager()
    {
        return $this->pageManager;
    }

    /**
     * @param PageManagerInterface $pageManager
     */
    public function setPageManager(PageManagerInterface $pageManager)
    {
        $this->pageManager = $pageManager;
    }
}
