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
namespace Search\Provider;

use Markdown\Exception\RuntimeException;
use Markdown\Service\RenderServiceInterface;
use Normalizer\NormalizerInterface;
use Search\Entity\Document;
use Taxonomy\Entity\TaxonomyTermInterface;
use Taxonomy\Manager\TaxonomyManagerInterface;
use Uuid\Filter\NotTrashedCollectionFilter;
use Zend\Mvc\Router\RouteInterface;
use Search\Exception\InvalidArgumentException;

class TaxonomyProvider implements ProviderInterface
{
    /**
     * @param TaxonomyManagerInterface $taxonomyManager
     * @param NormalizerInterface      $normalizer
     * @param RenderServiceInterface   $renderService
     * @param RouteInterface           $router
     */
    public function __construct(
        TaxonomyManagerInterface $taxonomyManager,
        NormalizerInterface $normalizer,
        RenderServiceInterface $renderService,
        RouteInterface $router
    ) {
        $this->taxonomyManager = $taxonomyManager;
        $this->renderService   = $renderService;
        $this->normalizer      = $normalizer;
        $this->router          = $router;
    }

    /**
     * {@inheritDoc}
     */
    public function getId($object)
    {
        if (!$object instanceof TaxonomyTermInterface) {
            throw new InvalidArgumentException(sprintf(
                'Expected TaxonomyTermInterface but got %s',
                is_object($object) ? get_class($object) : gettype($object)
            ));
        }
        return $object->getId();
    }

    /**
     * {@inheritDoc}
     */
    public function toDocument($object)
    {
        if (!$object instanceof TaxonomyTermInterface) {
            throw new InvalidArgumentException(sprintf(
                'Expected TaxonomyTermInterface but got %s',
                is_object($object) ? get_class($object) : gettype($object)
            ));
        }
        $normalized = $this->normalizer->normalize($object);
        $id         = $object->getId();
        $title      = $object->getName();
        $content    = $object->getDescription();
        $type       = $object->getType();
        $link       = $this->router->assemble(
            $normalized->getRouteParams(),
            ['name' => $normalized->getRouteName()]
        );
        $keywords   = $normalized->getMetadata()->getKeywords();
        $instance   = $object->getInstance()->getId();

        try {
            $content = $this->renderService->render($content);
        } catch (RuntimeException $e) {
            // Could not render -> nothing to do.
        }

        return new Document($id, $title, $content, $type, $link, $keywords, $instance);
    }

    /**
     * {@inheritDoc}
     */
    public function provide()
    {
        $container = [];
        $terms     = $this->taxonomyManager->findAllTerms(true);
        $filter    = new NotTrashedCollectionFilter();
        $terms     = $filter->filter($terms);
        /* @var $term TaxonomyTermInterface */
        foreach ($terms as $term) {
            $result      = $this->toDocument($term);
            $container[] = $result;
        }
        return $container;
    }
}
