<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */

namespace Alias\Factory;

use Alias\Controller\RefreshController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\SessionManager;

class RefreshControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $sessionManager SessionManager */
        $serviceLocator  = $serviceLocator->getServiceLocator();
        $aliasManager    = $serviceLocator->get('Alias\AliasManager');
        $taxonomyManager = $serviceLocator->get('Taxonomy\Manager\TaxonomyManager');
        $entityManager   = $serviceLocator->get('Entity\Manager\EntityManager');
        $normalizer      = $serviceLocator->get('Normalizer\Normalizer');
        return new RefreshController($aliasManager, $taxonomyManager, $entityManager, $normalizer);
    }
}
