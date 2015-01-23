<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Navigation\Factory;

use Navigation\View\Helper\Navigation;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NavigationHelperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $storage        = $serviceLocator->get('Navigation\Storage\NavigationHelperStorage');
        $pluginManager  = $serviceLocator->get('Zend\View\Helper\Navigation\PluginManager');
        $renderer       = $serviceLocator->get('Zend\View\Renderer\PhpRenderer');
        $helper         = new Navigation($storage);
        $helper->setView($renderer);
        $helper->setPluginManager($pluginManager);
        return $helper;
    }
}
