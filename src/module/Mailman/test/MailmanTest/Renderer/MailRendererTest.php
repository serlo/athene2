<?php
/**
 * This file is part of Athene2.
 *
 * Copyright (c) 2013-2018 Serlo Education e.V.
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
 * @copyright Copyright (c) 2013-2018 Serlo Education e.V.
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace module\Mailman\test\MailmanTest\Renderer;

use Doctrine\Common\Collections\ArrayCollection;
use Mailman\Renderer\MailRenderer;
use Notification\Entity\Notification;
use User\Entity\User;
use Uuid\Entity\UuidInterface;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;
use Zend\Test\Util\ModuleLoader;

class MailRendererTest extends AbstractControllerTestCase
{
    /**
     * @var MailRenderer
     */
    private $mailRenderer;

    protected function setUp()
    {
        parent::setUp();

        $config = require 'config/application.config.php';
        $this->setApplicationConfig($config);
        $this->getApplication()->bootstrap();
        $this->mailRenderer = $this->getApplicationServiceLocator()->get('Mailman\Renderer\MailRenderer');
    }

    /**
     * @param string $folder
     * @param array $data
     * @param array $checkVisibleData data to check if visible in mails
     * @dataProvider providerAllData
     */
    public function testRendering($folder, $data, $checkVisibleData = [])
    {
        $this->mailRenderer->setTemplateFolder($folder);

        $html = $this->mailRenderer->renderMail($data)->getHtmlBody();
        $plain = $this->mailRenderer->renderMail($data)->getPlainBody();

        //check that html didn't get escaped
        $this->assertNotContains('&lt', $html);
        $this->assertContains('<', $html);
        $this->assertNotContains('&lt', $plain);
        $this->assertNotContains('<', $plain);

        //check data
        foreach ($checkVisibleData as $dataCheck){
            $this->assertContains($dataCheck, $html);
            $this->assertContains($dataCheck, $plain);
        }
    }

    /**
     * @param string $folder
     * @dataProvider providerAllData
     */
    public function testTemplatesExist($folder)
    {
        $base = 'module/Ui/templates/';
        $this->assertFileExists($base . $folder . '/subject.twig');
        $this->assertFileExists($base . $folder . '/body.twig');
        $this->assertFileExists($base . $folder . '/plain.twig');
    }

    public function providerUserMailData()
    {
        $userDummy = new User();
        $userDummy->setUsername('UserDummy');

        return array(
            array('mailman/messages/welcome', [
                'body' => [
                    'user' => $userDummy,
                ],
            ], array($userDummy->getUsername())),
            array('mailman/messages/register', [
                'body' => [
                    'user' => $userDummy,
                ],
            ], array($userDummy->getUsername())),
            array('mailman/messages/restore-password', [
                'body' => [
                    'user' => $userDummy,
                ]
            ], array($userDummy->getUsername())),
        );
    }

    public function providerNotificationMailData()
    {
        return array_map(function ($eventType) {
            $userDummy = new User();
            $userDummy->setUsername('UserDummy');
            $notificationDummy = new Notification();
            $isDiscussion = substr($eventType,0, strlen('discussion')) === 'discussion';
            $data = [
                'body' => [
                    'user' => $userDummy,
                    'contentNotifications' => new ArrayCollection($isDiscussion ? array() : array($notificationDummy)),
                    'discussionNotifications' => new ArrayCollection($isDiscussion ? array($notificationDummy) : array()),
                ],
            ];

            return array('mailman/messages/notification', $data, array($userDummy->getUsername()));
        }, array(
//            'discussion/comment/archive',
//            'discussion/comment/create',
//            'discussion/create',
//            'entity/link/create',
//            'entity/revision/add',
//            'entity/revision/checkout',
//            'entity/revision/reject',
//            'taxonomy/term/parent/change',
//            'taxonomy/term/associate',
//            'taxonomy/term/dissociate',
//            'taxonomy/term/update',
//            'uuid/restore',
//            'uuid/trash'
        ));
    }

    public function providerAllData()
    {
        return array_merge($this->providerUserMailData(), $this->providerNotificationMailData());
    }
}
