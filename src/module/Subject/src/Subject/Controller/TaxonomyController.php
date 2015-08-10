<?php

/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Subject\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Entity\Entity\EntityInterface;
use Taxonomy\Exception\TermNotFoundException;
use Taxonomy\Manager\TaxonomyManagerAwareTrait;
use Zend\View\Model\ViewModel;

class TaxonomyController extends AbstractController
{
    public function indexAction()
    {
        try {
            $term = $this->getTerm();
        } catch (TermNotFoundException $e) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        /* @var $entities Collection|EntityInterface[] */
        $types    = [];
        $subject = $term->findAncestorByTypeName('subject');

        if(!is_object($subject)){
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $entities = $term->getAssociated('entities')->filter(
            function (EntityInterface $e) {
                return !$e->isTrashed() && $e->hasCurrentRevision();
            }
        );

        foreach ($entities as $e) {
            $types[$e->getType()->getName()][] = $e;
        }

        $types = new ArrayCollection($types);
        $view  = new ViewModel([
            'term'    => $term,
            'terms'   => $term ? $term->getChildren() : $subject->getChildren(),
            'subject' => $subject,
            'links'   => $entities,
            'types'   => $types
        ]);

        $view->setTemplate('subject/taxonomy/page/default');
        return $view;
    }
}
