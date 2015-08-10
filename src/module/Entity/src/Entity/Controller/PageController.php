<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Controller;

use Alias\AliasManagerAwareTrait;
use Entity\Options\ModuleOptions;
use Entity\Entity\EntityInterface;
use Entity\Options\RedirectOptions;
use Zend\View\Model\ViewModel;

class PageController extends AbstractController
{
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    public function setModuleOptions(ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    public function indexAction()
    {
        $entity = $this->getEntity();
        if (!$entity) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $type = $this->moduleOptions->getType($entity->getType()->getName());
        if ($type->hasComponent('redirect')) {
            /* @var $redirect RedirectOptions */
            $redirect = $type->getComponent('redirect');
            foreach ($entity->getChildren('link', $redirect->getToType()) as $child) {
                if (!$child->isTrashed() && $child->hasCurrentRevision()) {
                    return $this->redirect()->toRoute('uuid/get', ['uuid' => $child->getId()]);
                }
            }
        }

        $model = new ViewModel(['entity' => $entity]);
        $model->setTemplate('entity/page/default');

        if ($this->params('isXmlHttpRequest', false)) {
            $model->setTemplate('entity/view/default');
        }

        $this->layout('layout/3-col');

        if (!$entity->hasCurrentRevision()) {
            $this->layout('layout/2-col');
            $model->setTemplate('entity/page/pending');
        }

        return $model;
    }
}
