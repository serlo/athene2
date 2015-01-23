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

use Navigation\Manager\NavigationManagerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

trait NavigationManagerFactoryTrait
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return NavigationManagerInterface
     */
    protected function getNavigationManager(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->get('Navigation\Manager\NavigationManager');
    }
}
