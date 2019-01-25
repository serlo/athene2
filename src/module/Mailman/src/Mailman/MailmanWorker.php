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

namespace Mailman;

use ClassResolver\ClassResolverAwareTrait;
use Common\Traits\ObjectManagerAwareTrait;
use Notification\Entity\NotificationInterface;
use Zend\EventManager\EventManagerAwareTrait;

class MailmanWorker
{
    use ClassResolverAwareTrait;
    use EventManagerAwareTrait;
    use ObjectManagerAwareTrait;

    public function run()
    {
        $timeout = 60 * 20;
        ini_set('mysql.connect_timeout', $timeout);
        ini_set('default_socket_timeout', $timeout);

        $workload = [];

        foreach ($this->getWorkload() as $notification) {
            $subscriber = $notification->getUser();
            $id = $subscriber->getId();
            $workload[$id]['subscriber'] = $subscriber;
            $workload[$id]['notifications'][] = $notification;
        }

        foreach ($workload as $data) {
            $this->getEventManager()->trigger(
                'notify',
                $this,
                [
                    'notifications' => $data['notifications'],
                    'user' => $data['subscriber'],
                ]
            );
            // TODO: mark notifications as mailed, maybe see offset from NotificationWorker
        }

        $this->getObjectManager()->flush();
    }

    /**
     * @return NotificationInterface[]
     */
    protected function getWorkload()
    {
        $query = $this->getObjectManager()->createQuery(
            sprintf(
                'SELECT n FROM %s n WHERE n.seen = 0',
                $this->getClassResolver()->resolveClassName(NotificationInterface::class)
            )
        );

        return $query->getResult();
    }
}
