<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Navigation\Controller;

use Instance\Manager\InstanceManagerInterface;
use Navigation\Form\ContainerForm;
use Navigation\Form\PageForm;
use Navigation\Form\ParameterForm;
use Navigation\Form\ParameterKeyForm;
use Navigation\Form\PositionPageForm;
use Navigation\Manager\NavigationManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class NavigationController extends AbstractActionController
{
    /**
     * @var InstanceManagerInterface
     */
    protected $instanceManager;

    /**
     * @var NavigationManagerInterface
     */
    protected $navigationManager;

    /**
     * @var ContainerForm
     */

    protected $containerForm;

    /**
     * @var PageForm
     */
    protected $pageForm;

    /**
     * @var ParameterForm
     */
    protected $parameterForm;

    /**
     * @var ParameterKeyForm
     */
    protected $parameterKeyForm;

    public function __construct(
        InstanceManagerInterface $instanceManager,
        NavigationManagerInterface $navigationManager,
        ContainerForm $containerForm,
        PageForm $pageForm,
        ParameterForm $parameterForm,
        ParameterKeyForm $parameterKeyForm
    ) {
        $this->navigationManager = $navigationManager;
        $this->containerForm     = $containerForm;
        $this->pageForm          = $pageForm;
        $this->parameterForm     = $parameterForm;
        $this->parameterKeyForm  = $parameterKeyForm;
        $this->instanceManager   = $instanceManager;
    }

    public function createContainerAction()
    {
        $form     = $this->containerForm;
        $instance = $this->instanceManager->getInstanceFromRequest();
        $this->assertGranted('navigation.manage', $instance);

        if ($this->getRequest()->isPost()) {
            $data = array_merge($this->params()->fromPost(), ['instance' => $instance]);
            $form->setData($data);
            if ($form->isValid()) {
                $this->navigationManager->createContainer($form);
                $this->navigationManager->flush();
                $this->flashMessenger()->addSuccessMessage('The container was successfully created');

                return $this->redirect()->toUrl($this->referer()->fromStorage());
            }
        } else {
            $this->referer()->store();
        }

        $view = new ViewModel(['form' => $form]);
        $view->setTemplate('navigation/container/create');

        return $view;
    }

    public function createPageAction()
    {
        $container = $this->params('container');
        $this->assertGranted('navigation.manage', $this->navigationManager->getContainer($container));

        $data = [
            'container' => $container,
            'parent'    => $this->params('parent', null)
        ];

        $this->pageForm->setData($data);
        if ($this->pageForm->isValid()) {
            $this->navigationManager->createPage($this->pageForm);
            $this->navigationManager->flush();
            $this->flashMessenger()->addSuccessMessage('The container was successfully created');
        } else {
            $this->flashMessenger()->addErrorMessage('The container could not be created (validation failed)');
        }

        return $this->redirect()->toReferer();
    }

    public function createParameterAction()
    {
        $page = $this->params('page');
        $this->assertGranted('navigation.manage', $this->navigationManager->getPage($page));

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $this->parameterForm->setData($data);
            if ($this->parameterForm->isValid()) {
                $this->navigationManager->createParameter($this->parameterForm);
                $this->navigationManager->flush();

                return $this->redirect()->toUrl($this->referer()->fromStorage());
            }
        } else {
            $data = [
                'page'   => $page,
                'parent' => $this->params('parent', null)
            ];
            $this->parameterForm->setData($data);
            $this->referer()->store();
        }

        $view = new ViewModel(['form' => $this->parameterForm]);
        $view->setTemplate('navigation/parameter/create');

        return $view;
    }

    public function createParameterKeyAction()
    {
        $this->assertGranted('navigation.manage', $this->instanceManager->getInstanceFromRequest());

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $this->parameterKeyForm->setData($data);
            if ($this->parameterKeyForm->isValid()) {
                $this->navigationManager->createParameterKey($this->parameterKeyForm);
                $this->navigationManager->flush();

                return $this->redirect()->toUrl($this->referer()->fromStorage());
            }
        } else {
            $this->referer()->store();
        }

        $view = new ViewModel(['form' => $this->parameterKeyForm]);
        $view->setTemplate('navigation/parameter/key/create');

        return $view;
    }

    public function getContainerAction()
    {
        $container = $this->navigationManager->getContainer($this->params('container'));
        $this->assertGranted('navigation.manage', $container);

        $view = new ViewModel([
            'container'    => $container,
            'positionForm' => $this->pageForm
        ]);

        $view->setTemplate('navigation/container/get');

        return $view;
    }

    public function getPageAction()
    {
        $page = $this->navigationManager->getPage($this->params('page'));
        $this->assertGranted('navigation.manage', $page);

        $view = new ViewModel(['page' => $page]);

        $view->setTemplate('navigation/page/get');

        return $view;
    }

    public function indexAction()
    {
        $instance = $this->instanceManager->getInstanceFromRequest();
        $this->assertGranted('navigation.manage', $instance);

        $containers = $this->navigationManager->findContainersByInstance($instance);
        $view       = new ViewModel(['containers' => $containers]);

        $view->setTemplate('navigation/containers');

        return $view;
    }

    public function removeContainerAction()
    {
        $container = $this->navigationManager->getContainer($this->params('container'));
        $this->assertGranted('navigation.manage', $container);

        $this->navigationManager->removeContainer($container->getId());
        $this->navigationManager->flush();
        $this->flashMessenger()->addSuccessMessage('The container was successfully removed');

        return $this->redirect()->toReferer();
    }

    public function removePageAction()
    {
        $page = $this->navigationManager->getPage($this->params('page'));
        $this->assertGranted('navigation.manage', $page);
        $this->navigationManager->removePage($page->getId());
        $this->navigationManager->flush();
        $this->flashMessenger()->addSuccessMessage('The page was successfully removed');

        return $this->redirect()->toReferer();
    }

    public function removeParameterAction()
    {
        $parameter = $this->navigationManager->getParameter($this->params('parameter'));
        $this->assertGranted('navigation.manage', $parameter->getPage());
        $this->navigationManager->removeParameter($parameter->getId());
        $this->navigationManager->flush();
        $this->flashMessenger()->addSuccessMessage('The parameter was successfully removed');

        return $this->redirect()->toReferer();
    }

    public function updatePageAction()
    {
        $page = $this->navigationManager->getPage($this->params('page'));
        $this->assertGranted('navigation.manage', $page);
        $this->pageForm->bind($page);
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $this->pageForm->setData($data);
            if ($this->pageForm->isValid()) {
                $this->navigationManager->updatePage($this->pageForm);
                $this->navigationManager->flush();
                $this->flashMessenger()->addSuccessMessage('The page was successfully updated');
                return $this->redirect()->toReferer();
            }
        } else {
            $this->referer()->store();
        }

        $view = new ViewModel(['form' => $this->pageForm]);
        $view->setTemplate('navigation/page/update');

        return $view;
    }

    public function updateParameterAction()
    {
        $parameter = $this->navigationManager->getParameter($this->params('parameter'));
        $this->assertGranted('navigation.manage', $parameter->getPage());
        $this->parameterForm->bind($parameter);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $this->parameterForm->setData($data);
            if ($this->parameterForm->isValid()) {
                $this->navigationManager->updateParameter($this->parameterForm);
                $this->navigationManager->flush();

                return $this->redirect()->toUrl($this->referer()->fromStorage());
            }
        } else {
            $this->referer()->store();
        }

        $view = new ViewModel(['form' => $this->parameterForm]);
        $view->setTemplate('navigation/parameter/update');

        return $view;
    }
}
