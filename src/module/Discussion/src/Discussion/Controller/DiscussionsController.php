<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Discussion\Controller;

use Instance\Manager\InstanceManagerAwareTrait;
use Taxonomy\Exception\TermNotFoundException;
use Taxonomy\Manager\TaxonomyManagerAwareTrait;
use User\Manager\UserManagerAwareTrait;
use Zend\View\Model\ViewModel;

class DiscussionsController extends AbstractController
{
    use TaxonomyManagerAwareTrait, InstanceManagerAwareTrait, UserManagerAwareTrait;

    public function indexAction()
    {
        $instance    = $this->getInstanceManager()->getInstanceFromRequest();
        $page        = $this->params()->fromQuery('page', 1);
        $discussions = $this->getDiscussionManager()->findDiscussionsByInstance($instance, $page);

        $view = new ViewModel([
            'discussions' => $discussions,
            'user'        => $this->getUserManager()->getUserFromAuthenticator()
        ]);

        $view->setTemplate('discussion/discussions/index');
        return $view;
    }

    public function redirectAction() {
        $r = $this->redirect()->toRoute('discussion/discussions');
        $this->getResponse()->setStatusCode(301);
        return $r;
    }
}
