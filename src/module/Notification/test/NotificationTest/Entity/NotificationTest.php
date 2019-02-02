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

namespace NotificationTest\Entity;

use CommonTest\Entity\JsonSerializableInterfaceMock;
use Notification\Entity\Notification;
use Notification\Entity\NotificationInterface;
use PHPUnit\Framework\TestCase;

class NotificationTest extends TestCase
{
    /**
     * @var array
     */
    private $json;

    public function setUp()
    {
        /**
         * @var $notification NotificationInterface
         */
        $notification = $this->createNotificationMock();
        $this->json = $notification->toJson();
    }

    public function testToJsonContainsId()
    {
        $this->assertEquals(1337, $this->json['id']);
    }

    public function testToJsonContainsSeen()
    {
        $this->assertEquals(true, $this->json['seen']);
    }

    public function testToJsonContainsEvent()
    {
        $this->assertEquals(['type' => 'event'], $this->json['event']);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createNotificationMock()
    {
        $notification = $this->getMockBuilder(Notification::class)
            ->setMethods(['getId', 'getSeen', 'getEvent'])
            ->getMock();
        $notification->method('getId')->willReturn(1337);
        $notification->method('getSeen')->willReturn(true);
        $notification->method('getEvent')->willReturn(
            JsonSerializableInterfaceMock::create($this, ['type' => 'event'])
        );
        return $notification;
    }
}
