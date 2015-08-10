<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Factory;

use RelatedContent\View\Helper\RelatedContentHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RelatedContentHelperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $instance = new RelatedContentHelper();
        $relatedContentManager = $serviceLocator->getServiceLocator()->get(
                'RelatedContent\Manager\RelatedContentManager'
            );

        $instance->setRelatedContentManager($relatedContentManager);

        return $instance;
    }
}
