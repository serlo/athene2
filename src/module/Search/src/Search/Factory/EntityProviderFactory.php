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
namespace Search\Factory;

use Search\Provider\EntityProvider;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EntityProviderFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator AbstractPluginManager */
        $serviceLocator = $serviceLocator->getServiceLocator();
        $renderService  = $serviceLocator->get('Markdown\Service\HtmlRenderService');
        $normalizer     = $serviceLocator->get('Normalizer\Normalizer');
        $entityManager  = $serviceLocator->get('Entity\Manager\EntityManager');
        $options        = $serviceLocator->get('Entity\Options\ModuleOptions');
        $router         = $serviceLocator->get('HttpRouter');

        return new EntityProvider($entityManager, $options, $normalizer, $renderService, $router);
    }
}
