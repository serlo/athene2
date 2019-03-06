<?php
/**
 * This file is part of Athene2.
 *
 * Copyright (c) 2013-2019 Serlo Education e.V.
 *
 * Licensed under the Apache License, Version 2.0 (the "License")
 * you may not use this file except in compliance with the License
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @copyright Copyright (c) 2013-2019 Serlo Education e.V.
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification\Controller;

use Notification\Entity\NotificationInterface;
use Notification\NotificationManagerAwareTrait;
use Notification\NotificationManagerInterface;
use User\Manager\UserManagerAwareTrait;
use User\Manager\UserManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZfcRbac\Service\AuthorizationService;

class NotificationController extends AbstractActionController
{
    use NotificationManagerAwareTrait;
    use UserManagerAwareTrait;

    /**
     * @var \ZfcRbac\Service\AuthorizationService
     */
    protected $authorizationService;

    public function __construct(
        NotificationManagerInterface $notificationManager,
        AuthorizationService $authorizationService,
        UserManagerInterface $userManager
    ) {
        $this->notificationManager  = $notificationManager;
        $this->authorizationService = $authorizationService;
        $this->userManager = $userManager;
    }

    public function readAction()
    {
        $user = $this->authorizationService->getIdentity();
        if ($user) {
            $this->notificationManager->markRead($user);
            $this->notificationManager->flush();
        }
        return new JsonModel([]);
    }

    public function indexAction()
    {
        $user = $this->authorizationService->getIdentity();
        if ($user) {
            $notifications = $this->notificationManager->findNotificationsBySubscriber($user);
            return new JsonModel($notifications->map(function (NotificationInterface $notification) {
                return $notification->toJson();
            }));
        }

        $this->getResponse()->setStatusCode(403);
        return new JsonModel([]);
    }

    public function createAction()
    {
        $actorId  = $this->params()->fromQuery('actor');
        $actor = $this->userManager->getUser($actorId);

        $name = $this->params()->fromQuery('name');

        $parameters = json_decode($this->params()->fromQuery('params'));
//        $this->getEventManager()->trigger('start',
//            $this,
//            [
//                'author'     => $actor,
//                'on'         => $parameters['on'],
//                'discussion' => $comment,
//                'instance'   => $comment->getInstance(),
//                'data'       => ,
//            ]);
//        $eventLog = $this->getEventManager()->logEvent($name, null, null, $parameters, $actor);
//        return new JsonModel($eventLog);
        var_dump($parameters);
    }
}
