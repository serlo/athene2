<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Common\Factory;

use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceLocatorInterface;

trait EntityManagerFactoryTrait
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return EntityManager
     */
    public function getEntityManager(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->get('Doctrine\ORM\EntityManager');
    }
}
