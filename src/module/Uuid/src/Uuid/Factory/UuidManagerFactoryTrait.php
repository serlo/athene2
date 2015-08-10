<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Uuid\Factory;

use Uuid\Manager\UuidManagerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

trait UuidManagerFactoryTrait
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return UuidManagerInterface
     */
    protected function getUuidManager(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->get('Uuid\Manager\UuidManager');
    }
}
