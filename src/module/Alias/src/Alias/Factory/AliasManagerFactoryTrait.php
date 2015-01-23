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

use Alias\AliasManagerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

trait AliasManagerFactoryTrait {
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return AliasManagerInterface
     */
    public function getAliasManager(ServiceLocatorInterface $serviceLocator){
        return $serviceLocator->get('Alias\AliasManager');
    }
}
