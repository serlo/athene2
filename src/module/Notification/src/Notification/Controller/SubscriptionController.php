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
namespace Notification\Controller;

use Notification\Exception\RuntimeException;
use Notification\SubscriptionManagerInterface;
use Uuid\Exception\NotFoundException;
use Uuid\Manager\UuidManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZfcRbac\Exception\UnauthorizedException;
use ZfcRbac\Service\AuthorizationService;

class SubscriptionController extends AbstractActionController
{

    /**
     * @var SubscriptionManagerInterface
     */
    protected $subscriptionManager;

    /**
     * @var UuidManagerInterface
     */
    protected $uuidManager;

    /**
     * @var AuthorizationService
     */
    protected $authorizationService;

    public function __construct(
        AuthorizationService $authorizationService,
        UuidManagerInterface $uuidManager,
        SubscriptionManagerInterface $subscriptionManager
    ) {
        $this->subscriptionManager  = $subscriptionManager;
        $this->uuidManager          = $uuidManager;
        $this->authorizationService = $authorizationService;
    }

    public function manageAction()
    {
        if ($this->authorizationService->getIdentity() === null) {
            throw new UnauthorizedException;
        }

        $user          = $this->authorizationService->getIdentity();
        $subscriptions = $this->subscriptionManager->findSubscriptionsByUser($user);
        $view          = new ViewModel(['subscriptions' => $subscriptions]);
        $view->setTemplate('notification/subscription/manage');
        return $view;
    }

    public function subscribeAction()
    {
        if (!$this->authorizationService->getIdentity()) {
            throw new UnauthorizedException;
        }

        $object = $this->params('object');
        $email  = $this->params('email');
        $user   = $this->authorizationService->getIdentity();

        try {
            $object = $this->uuidManager->getUuid($object);
        } catch (NotFoundException $e) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $this->subscriptionManager->subscribe($user, $object, $email);
        $this->subscriptionManager->flush();
        $this->flashMessenger()->addSuccessMessage('You are now receiving notifications for this content.');
        return $this->redirect()->toReferer();
    }

    public function updateAction()
    {
        if (!$this->authorizationService->getIdentity()) {
            throw new UnauthorizedException;
        }

        $object = $this->params('object');
        $email  = $this->params('email', false);
        $user   = $this->authorizationService->getIdentity();

        try {
            $object = $this->uuidManager->getUuid($object);
            $this->subscriptionManager->update($user, $object, $email);
            $this->subscriptionManager->flush();
            $this->flashMessenger()->addSuccessMessage('Your subscription has been updated successfully.');
        } catch (NotFoundException $e) {
            $this->flashMessenger()->addErrorMessage('The object you are trying to subscribe to does not exist.');
        } catch (RuntimeException $e) {
            $this->flashMessenger()->addErrorMessage(
                'You can\'t update your subscription because you did not subscribe to this object.'
            );
        }

        return $this->redirect()->toReferer();
    }

    public function unsubscribeAction()
    {
        if (!$this->authorizationService->getIdentity()) {
            throw new UnauthorizedException;
        }

        $object = $this->params('object');
        $user   = $this->authorizationService->getIdentity();

        try {
            $object = $this->uuidManager->getUuid($object);
        } catch (NotFoundException $e) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $this->subscriptionManager->unSubscribe($user, $object);
        $this->subscriptionManager->flush();
        $this->flashMessenger()->addSuccessMessage('You are no longer receiving notifications for this content.');
        return $this->redirect()->toReferer();
    }
}
