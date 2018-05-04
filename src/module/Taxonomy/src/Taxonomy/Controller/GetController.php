<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Taxonomy\Controller;

use Taxonomy\Exception\TermNotFoundException;
use Zend\View\Model\ViewModel;

class GetController extends AbstractController
{
    public function indexAction()
    {
        $this->setupAPI();

        try {
            $term = $this->getTerm();
        } catch (TermNotFoundException $e) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $siblings = [];

        if ($term->hasParent()) {
            $siblings = $term->getParent()->findChildrenByTrashed(false)->filter(function ($item) use (&$term) {
                return $item->getTaxonomy()->getName() === $term->getTaxonomy()->getName() && $item->getId() != $term->getId();

            });
        }

        if (count($siblings) > 0) {
            $this->layout('layout/3-col');
        }

        $view = new ViewModel(['term' => $term, 'siblings' => $siblings]);

        $view->setTemplate('taxonomy/term/page/default');
        return $view;
    }
}
