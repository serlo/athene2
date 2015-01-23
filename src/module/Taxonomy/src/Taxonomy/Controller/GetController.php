<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Taxonomy\Controller;

use Taxonomy\Exception\TermNotFoundException;
use Zend\View\Model\ViewModel;

class GetController extends AbstractController
{
    public function indexAction()
    {
        try {
            $term = $this->getTerm();
        } catch (TermNotFoundException $e) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $view = new ViewModel(['term' => $term]);

        $view->setTemplate('taxonomy/term/page/default');
        return $view;
    }
}
