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
namespace UserTest\Entity;

use User\Entity\User;
use User\Entity\UserInterface;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $json;

    public function setUp()
    {
        /**
         * @var $user UserInterface
         */
        $user = $this->createUserMock();
        $this->json = $user->toJson();
    }

    public function testToJsonContainsId()
    {
        $this->assertEquals(1337, $this->json['id']);
    }

    public function testToJsonContainsUsername()
    {
        $this->assertEquals('foobar', $this->json['username']);
    }

    private function createUserMock()
    {
        $user = $this->getMockBuilder(User::class)
            ->setMethods(['getId', 'getUsername'])
            ->getMock();
        $user->method('getId')->willReturn(1337);
        $user->method('getUsername')->willReturn('foobar');
        return $user;
    }
}
