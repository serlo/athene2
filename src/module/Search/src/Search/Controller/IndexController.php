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
namespace Search\Controller;

use Search\SearchServiceInterface;
use Zend\Mvc\Controller\AbstractConsoleController;

/**
 * A controller for controlling the index.
 */
class IndexController extends AbstractConsoleController
{
    /**
     * @var SearchServiceInterface
     */
    protected $searchService;

    /**
     * @param SearchServiceInterface $searchService
     */
    public function __construct(
        SearchServiceInterface $searchService
    ) {
        $this->searchService = $searchService;
    }

    public function rebuildAction()
    {
        $this->searchService->rebuild();
        $this->searchService->flush();
        return 'success';
    }
}
