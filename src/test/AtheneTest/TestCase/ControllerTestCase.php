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
namespace AtheneTest\TestCase;

abstract class ControllerTestCase extends ObjectManagerTestCase
{

    /**
     * @var \Zend\Mvc\Controller\AbstractActionController
     */
    protected $controller;

    protected function prepareLanguageFromRequest($id, $code)
    {
        $languageManagerMock = $this->createMock('Language\Manager\LanguageManager');
        $languageServiceMock = $this->createMock('Language\Service\LanguageService');

        $languageManagerMock->expects($this->atLeastOnce())
            ->method('getLanguageFromRequest')
            ->will($this->returnValue($languageServiceMock));

        $languageServiceMock->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($id));

        $languageServiceMock->expects($this->any())
            ->method('getCode')
            ->will($this->returnValue($code));

        return $languageManagerMock;
    }

    protected function preparePluginManager()
    {
        if ($this->controller->getPluginManager() instanceof \PHPUnit_Framework_MockObject_MockObject) {
            return $this->controller->getPluginManager();
        }

        $pluginManager = $this->createMock('Zend\Mvc\Controller\PluginManager');
        $this->controller->setPluginManager($pluginManager);

        return $pluginManager;
    }
}
