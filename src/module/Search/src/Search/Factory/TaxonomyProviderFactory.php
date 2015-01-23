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

use Search\Provider\TaxonomyProvider;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TaxonomyProviderFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator AbstractPluginManager */
        $serviceLocator  = $serviceLocator->getServiceLocator();
        $renderService   = $serviceLocator->get('Markdown\Service\HtmlRenderService');
        $normalizer      = $serviceLocator->get('Normalizer\Normalizer');
        $taxonomyManager = $serviceLocator->get('Taxonomy\Manager\TaxonomyManager');
        $router          = $serviceLocator->get('HttpRouter');

        return new TaxonomyProvider($taxonomyManager, $normalizer, $renderService, $router);
    }
}
