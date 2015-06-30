<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace User\Controller;

use Instance\Manager\InstanceManagerAwareTrait;
use User\Exception\UserNotFoundException;
use User\Form\SettingsForm;
use Zend\Form\Form;
use Zend\View\Model\ViewModel;
use ZfcRbac\Exception\UnauthorizedException;

class UserController extends AbstractUserController
{
    use InstanceManagerAwareTrait;

    protected $forms = [
        'register'         => 'User\Form\Register',
        'login'            => 'User\Form\Login',
        'user_select'      => 'User\Form\SelectUserForm',
        'restore_password' => 'User\Form\LostPassword',
        'settings'         => 'User\Form\SettingsForm'
    ];

    public function meAction()
    {
        $user = $this->getUserManager()->getUserFromAuthenticator();

        if (!$user) {
            throw new UnauthorizedException;
        }
        $view = new ViewModel(['user' => $user]);
        $view->setTemplate('user/user/profile');
        return $view;
    }

    public function profileAction()
    {
        try {
            $id = $this->params('id');
            if (is_numeric($id)) {
                $user = $this->getUserManager()->getUser($id);
            } else {
                $user = $this->getUserManager()->findUserByUsername($id);
            }
        } catch (UserNotFoundException $e) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }
        $view = new ViewModel(['user' => $user]);
        $view->setTemplate('user/user/profile');
        return $view;
    }

    public function registerAction()
    {
        if ($this->getUserManager()->getUserFromAuthenticator()) {
            return $this->redirect()->toRoute('home');
        }

        $this->layout('layout/1-col');
        $form = $this->getForm('register');

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if ($form->isValid()) {
                $user = $this->getUserManager()->createUser($form->getData());

                $this->getEventManager()->trigger(
                    'register',
                    $this,
                    [
                        'user'     => $user,
                        'instance' => $this->getInstanceManager()->getInstanceFromRequest(),
                        'data'     => $data
                    ]
                );

                $this->getUserManager()->persist($user);
                $this->getUserManager()->flush();
                $this->flashMessenger()->addSuccessMessage(
                    'You have registered successfully and'
                    . 'will soon receive an email with instructions on'
                    . 'how to activate your account.'
                );
                return $this->redirect()->toUrl($this->params('ref', '/'));
            }
        }

        $view = new ViewModel([
            'form' => $form
        ]);

        return $view;
    }

    public function getForm($name)
    {
        if (!is_object($this->forms[$name])) {
            $form = $this->forms[$name];
            if ($name === 'register') {
                $this->forms[$name] = new $form(
                    $this->getUserManager()->getObjectManager(),
                    $this->getServiceLocator()->get('MvcTranslator')
                );
            } else if ($name === 'settings') {
                $this->forms[$name] = new $form($this->getUserManager()->getObjectManager());
            } else if ($name === 'login') {
                $this->forms[$name] = new $form($this->getServiceLocator()->get('MvcTranslator'));
            } else {
                $this->forms[$name] = new $form();
            }
        }

        return $this->forms[$name];
    }

    /**
     * @param string $name
     * @param Form   $form
     * @return self
     */
    public function setForm($name, Form $form)
    {
        $this->forms[$name] = $form;
    }

    public function settingsAction()
    {
        $user = $this->getUserManager()->getUserFromAuthenticator();
        if (!$user) {
            throw new UnauthorizedException;
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form = new SettingsForm($this->getUserManager()->getObjectManager(), $data['email'] === $user->getEmail());
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $user->setEmail($data['email']);
                $user->setDescription($data['description']);

                $this->getUserManager()->persist($user);
                $this->getUserManager()->flush();
                $this->flashMessenger()->addSuccessMessage(
                    'Your profile has been saved'
                );

                return $this->redirect()->toRoute('user/me');
            }
        } else {
            $form = new SettingsForm($this->getUserManager()->getObjectManager());
            $data = [
                'email' => $user->getEmail(),
                'description' => $user->getDescription()
            ];
            $form->setData($data);
        }

        $view = new ViewModel(['user' => $user, 'form' => $form]);
        $view->setTemplate('user/user/settings');
        $this->layout('athene2-editor');

        return $view;
    }
}
