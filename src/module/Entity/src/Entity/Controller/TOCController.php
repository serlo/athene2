<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Controller;

use Entity\Options\ModuleOptions;
use Zend\View\Model\ViewModel;

class TOCController extends AbstractController
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
        $type = $this->moduleOptions->getType($entity->getType()->getName());

        if (!$entity || $entity->isTrashed() || !$type->hasComponent('tableOfContents')) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $view = new ViewModel([
            'entity' => $entity
        ]);

        $view->setTemplate('entity/view/toc/default');

        $this->layout('layout/3-col');

        if (!$entity->hasCurrentRevision()) {
            $this->layout('layout/2-col');
            $view->setTemplate('entity/page/pending');
        }

        return $view;
    }
}
