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

namespace EventTest\Entity;

use CommonTest\Entity\JsonSerializableInterfaceMock;
use Doctrine\Common\Collections\ArrayCollection;
use Event\Entity\EventInterface;
use Event\Entity\EventLog;
use Event\Entity\EventLogInterface;
use Event\Entity\EventParameterInterface;

class EventLogTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $json;

    public function setUp()
    {
        /**
         * @var $eventLog EventLogInterface
         */
        $eventLog = $this->createEventLogMock();
        $this->json = $eventLog->toJson();
    }

    public function testToJsonContainsId()
    {
        $this->assertEquals(1337, $this->json['id']);
    }

    public function testToJsonContainsName()
    {
        $this->assertEquals('foobar', $this->json['name']);
    }

    public function testToJsonContainsActor()
    {
        $this->assertEquals(['type' => 'actor'], $this->json['actor']);
    }

    public function testToJsonContainsObject()
    {
        $this->assertEquals(['type' => 'object'], $this->json['object']);
    }

    public function testToJsonContainsParams()
    {
        $this->assertEquals('bar', $this->json['params']['foo']);
    }

    public function testToJsonContainsTimestamp()
    {
        $this->assertEquals(1546300800, $this->json['timestamp']);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     * @throws \Exception
     */
    private function createEventLogMock(): \PHPUnit_Framework_MockObject_MockObject
    {
        $eventLog = $this->getMockBuilder(EventLog::class)
            ->setMethods([
                'getId',
                'getEvent',
                'getActor',
                'getObject',
                'getTimestamp',
                'getParameters',
            ])
            ->getMock();
        $eventLog->method('getId')->willReturn(1337);
        $eventLog->method('getEvent')->willReturn($this->createEventMock());
        $eventLog->method('getActor')->willReturn(
            JsonSerializableInterfaceMock::create($this, ['type' => 'actor'])
        );
        $eventLog->method('getObject')->willReturn(
            JsonSerializableInterfaceMock::create($this, ['type' => 'object'])
        );
        $eventLog->method('getTimestamp')->willReturn(new \DateTime('2019-01-01'));
        $eventLog->method('getParameters')->willReturn(
            new ArrayCollection([$this->createParameterMock()])
        );
        return $eventLog;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createEventMock(): \PHPUnit_Framework_MockObject_MockObject
    {
        $event = $this->getMockBuilder(EventInterface::class)
            ->getMock();
        $event->method('getName')->willReturn('foobar');
        return $event;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createParameterMock(): \PHPUnit_Framework_MockObject_MockObject
    {
        $paramName = $this->getMockBuilder(EventParameterInterface::class)->getMock();
        $paramName->method('getName')->willReturn('foo');
        $paramValue = JsonSerializableInterfaceMock::create($this, 'bar');
        $param = $this->getMockBuilder(EventParameterInterface::class)->getMock();
        $param->method('getName')->willReturn($paramName);
        $param->method('getValue')->willReturn($paramValue);
        return $param;
    }
}
