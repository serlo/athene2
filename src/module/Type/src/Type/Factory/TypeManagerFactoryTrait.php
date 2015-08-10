<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Type\Factory;

use Type\TypeManagerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

trait TypeManagerFactoryTrait
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return TypeManagerInterface
     */
    public function getTypeManager(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->get('Type\TypeManager');
    }
}
