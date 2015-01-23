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

use Alias\AliasManagerAwareTrait;
use Zend\View\Model\ViewModel;

class PageController extends AbstractController
{
    public function indexAction()
    {
        $entity = $this->getEntity();

        if (!$entity) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $model = new ViewModel(['entity' => $entity]);
        $model->setTemplate('entity/page/default');

        if ($this->params('isXmlHttpRequest', false)) {
            $model->setTemplate('entity/view/default');
        }

        $this->layout('layout/3-col');

        if(!$entity->hasCurrentRevision()){
            $this->layout('layout/2-col');
            $model->setTemplate('entity/page/pending');
        }

        return $model;
    }
}
