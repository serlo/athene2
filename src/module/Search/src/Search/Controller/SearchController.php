<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
    public function searchAction()
    {
        $form = new SearchForm();
        $view = new ViewModel(['form' => $form, 'query' => '']);

        $view->setTemplate('search/search');

        $data = $this->getRequest()->getQuery();
        if (isset($data['q'])) {
            $form->setData($data);
            if ($form->isValid()) {
                $data      = $form->getData();
                $view->setVariable('query', $data['q']);
                $view->setTemplate('search/results');
            }
        }

        return $view;
    }
}
