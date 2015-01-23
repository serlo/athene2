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
namespace User\Factory;

use User\Manager\UserManager;
use Zend\ServiceManager\ServiceLocatorInterface;

trait UserManagerFactoryTrait
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return UserManager
     */
    protected function getUserManager(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->get('User\Manager\UserManager');
    }
}
