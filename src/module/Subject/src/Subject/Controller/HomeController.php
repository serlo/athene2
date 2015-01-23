<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license	LGPL-3.0
 * @license	http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Subject\Controller;

use Zend\View\Model\ViewModel;

class HomeController extends AbstractController
{

    public function indexAction()
    {
        $view = new ViewModel([
            'subject' => $this->getSubject()
        ]);
        $view->setTemplate('subject/home/index');
        return $view;
    }
}
