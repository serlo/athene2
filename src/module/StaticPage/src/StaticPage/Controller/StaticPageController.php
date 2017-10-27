<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace StaticPage\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class StaticPageController extends AbstractActionController
{
    public function spendenAction()
    {
        $view = new ViewModel();
        $view->setTemplate('static/emptyTemplate');
        $this->layout('static/spenden');
        return $view;
    }
}
