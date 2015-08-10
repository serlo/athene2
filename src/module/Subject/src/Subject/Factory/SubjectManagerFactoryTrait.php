<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Subject\Factory;

use Subject\Manager\SubjectManagerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

trait SubjectManagerFactoryTrait
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return SubjectManagerInterface
     */
    public function getSubjectManager(ServiceLocatorInterface $serviceLocator)
    {
        return $serviceLocator->get('Subject\Manager\SubjectManager');
    }
}
