<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Uuid\Controller;

use Uuid\Manager\UuidManagerAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UuidController extends AbstractActionController
{
    use UuidManagerAwareTrait;

    public function recycleBinAction()
    {
        $entities = $this->getUuidManager()->findByTrashed(true);
        $view     = new ViewModel(['entities' => $entities]);
        $view->setTemplate('uuid/recycle-bin');
        return $view;
    }

    public function trashAction()
    {
        $this->getUuidManager()->trashUuid($this->params('id'));
        $this->getUuidManager()->flush();
        $this->flashMessenger()->addSuccessMessage('The content has been trashed.');
        return $this->redirect()->toReferer();
    }

    public function restoreAction()
    {
        $this->getUuidManager()->restoreUuid($this->params('id'));
        $this->getUuidManager()->flush();
        $this->flashMessenger()->addSuccessMessage('The content has been restored.');
        return $this->redirect()->toReferer();
    }

    public function purgeAction()
    {
        $this->getUuidManager()->purgeUuid($this->params('id'));
        $this->getUuidManager()->flush();
        $this->flashMessenger()->addSuccessMessage('The content has been removed.');
        return $this->redirect()->toReferer();
    }
}
