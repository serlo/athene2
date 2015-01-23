<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Controller;

use Instance\Manager\InstanceManagerAwareTrait;
use Taxonomy\Manager\TaxonomyManagerAwareTrait;
use Zend\View\Model\ViewModel;

class TaxonomyController extends AbstractController
{
    use InstanceManagerAwareTrait, TaxonomyManagerAwareTrait;

    public function updateAction()
    {
        $entity = $this->getEntity();

        if (!$entity || $entity->isTrashed()) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $instance = $this->getInstanceManager()->getInstanceFromRequest();
        $taxonomy = $this->getTaxonomyManager()->findTaxonomyByName('root', $instance);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            if (array_key_exists('terms', $data)) {
                foreach ($data['terms'] as $termId => $added) {
                    $term = $this->getTaxonomyManager()->getTerm($termId);

                    if ($added == 1) {
                        $this->getTaxonomyManager()->associateWith($termId, $entity);
                        $event = 'addToTerm';
                    } else {
                        $this->getTaxonomyManager()->removeAssociation($termId, $entity);
                        $event = 'removeFromTerm';
                    }

                    $this->getEventManager()->trigger(
                        $event,
                        $this,
                        [
                            'entity' => $entity,
                            'term'   => $term
                        ]
                    );
                }

                $this->getEntityManager()->flush();
                $this->redirect()->toUrl(
                    $this->referer()->fromStorage()
                );

                return false;
            }
        } else {
            $this->referer()->store();
        }

        $view = new ViewModel([
            'terms'  => $taxonomy->getChildren(),
            'entity' => $entity
        ]);
        $view->setTemplate('entity/taxonomy/update');

        return $view;
    }
}
