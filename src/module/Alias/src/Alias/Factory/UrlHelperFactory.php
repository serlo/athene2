<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Alias\Factory;


use Alias\View\Helper\Url;
use Zend\Console\Console;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UrlHelperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $helperPluginManager
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $helperPluginManager)
    {
        $serviceLocator = $helperPluginManager->getServiceLocator();
        $aliasManager   = $serviceLocator->get('Alias\AliasManager');
        $tenantManager  = $serviceLocator->get('Instance\Manager\InstanceManager');
        $isConsole      = Console::isConsole();
        $router         = $isConsole ? 'HttpRouter' : 'Router';
        $match          = $serviceLocator->get('application')->getMvcEvent()->getRouteMatch();
        $helper         = new Url($aliasManager, $tenantManager);

        $helper->setRouter($serviceLocator->get($router));

        $interface = 'Zend\Mvc\Router\\';
        $interface = $interface . $isConsole ? 'Console' : 'Http';
        $interface = $interface . '\RouteMatch';

        if ($match instanceof $interface) {
            $helper->setRouteMatch($match);
        }

        return $helper;
    }
}
