<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license	    LGPL-3.0
 * @license	    http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright	Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace AtheneTest\TestCase;

abstract class ControllerTestCase extends ObjectManagerTestCase
{

    /**
     *
     * @var \Zend\Mvc\Controller\AbstractActionController
     */
    protected $controller;

    protected function prepareLanguageFromRequest($id, $code)
    {
        $languageManagerMock = $this->getMock('Language\Manager\LanguageManager');
        $languageServiceMock = $this->getMock('Language\Service\LanguageService');
        
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
        
        $pluginManager = $this->getMock('Zend\Mvc\Controller\PluginManager');
        $this->controller->setPluginManager($pluginManager);
        
        return $pluginManager;
    }
}