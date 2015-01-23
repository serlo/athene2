<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Search\Controller;

use Search\Form\SearchForm;
use Search\SearchServiceAwareTrait;
use Search\SearchServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class SearchController extends AbstractActionController
{
    use SearchServiceAwareTrait;

    /**
     * @param SearchServiceInterface $searchService
     */
    public function __construct(SearchServiceInterface $searchService)
    {
        $this->searchService = $searchService;
    }

    public function ajaxAction()
    {
        $form = new SearchForm();
        $data = $this->getRequest()->getQuery();
        if (isset($data['q'])) {
            $form->setData($data);
            if ($form->isValid()) {
                $data      = $form->getData();
                $container = $this->getSearchService()->search($data['q']);
                $view      = new JsonModel($container->toArray());
                return $view;
            }
        }
        return new JsonModel([]);
    }

    public function searchAction()
    {
        $form = new SearchForm();
        $view = new ViewModel(['form' => $form, 'query' => '']);
        $page = $this->params()->fromQuery('page', 0);

        $view->setTemplate('search/search');

        $data = $this->getRequest()->getQuery();
        if (isset($data['q'])) {
            $form->setData($data);
            if ($form->isValid()) {
                $data      = $form->getData();
                $container = $this->getSearchService()->search($data['q'], $page, 10);
                $view->setVariable('container', $container);
                $view->setVariable('query', $data['q']);
                $view->setTemplate('search/results');
            }
        }

        return $view;
    }
}
