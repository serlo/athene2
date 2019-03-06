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
use Uuid\Manager\UuidManagerAwareTrait;
use Uuid\Manager\UuidManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZfcRbac\Service\AuthorizationService;

class NotificationController extends AbstractActionController
{
    use NotificationManagerAwareTrait;
    use UserManagerAwareTrait;
    use UuidManagerAwareTrait;

    /**
     * @var \ZfcRbac\Service\AuthorizationService
     */
    protected $authorizationService;

    public function __construct(
        NotificationManagerInterface $notificationManager,
        AuthorizationService $authorizationService,
        UserManagerInterface $userManager,
        UuidManagerInterface $uuidManager
    ) {
        $this->notificationManager  = $notificationManager;
        $this->authorizationService = $authorizationService;
        $this->userManager = $userManager;
        $this->uuidManager = $uuidManager;
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
        $payload = json_decode($this->getRequest()->getContent(), true);

        $event = $payload['event'];
        $entity = $payload['entity'];
        $comment = $payload['comment'];
        $thread = $payload['comments'];

        $authorId  = $comment['user_id'];
        $author = $this->userManager->getUser($authorId);

        $users = [];
        foreach ($thread as $threadComment ) {
            if ($threadComment['user_id'] !== $authorId) {
                $users[] = $this->userManager->getUser($threadComment['user_id']);
            }
        }
        $object = $this->uuidManager->getUuid($entity['external_id'], true);
        $this->getEventManager()->trigger(
            'phabricator',
            [
                'type'      => $event,
                'author'    => $author,
                'on'        => $object,
                'data'      => $comment['body'],
                'users'     => $users,
                'timestamp' => $comment['updated_at']
            ]
        );
        return new JsonModel(['event' => $event, 'author' => $author->getUsername(), 'entity' => $object->getId(), 'comment' => $comment]);
    }

    private function handleCommentCreate($entityJSON, $commentJSON, $commentsJSON) {
    }
}
