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

namespace UuidTest\Entity;

use PHPUnit\Framework\TestCase;
use Uuid\Entity\Uuid;
use Uuid\Entity\UuidInterface;

class UuidTest extends TestCase
{
    public function testToJsonIsId()
    {
        /**
         * @var $uuid UuidInterface
         */
        $uuid = $this->createUuidMock();
        $this->assertEquals(1337, $uuid->toJson());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createUuidMock()
    {
        $uuid = $this->getMockBuilder(Uuid::class)
            ->setMethods(['getId'])
            ->getMock();
        $uuid->method('getId')->willReturn(1337);
        return $uuid;
    }
}
