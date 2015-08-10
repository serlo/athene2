<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
use Taxonomy\Filter\TaxonomyTypeCollectionFilter;
use Uuid\Filter\NotTrashedCollectionFilter;
use Zend\Mvc\Router\RouteInterface;
use Search\Exception\InvalidArgumentException;
use Zend\Filter\FilterChain;

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
        $notTrashed = new NotTrashedCollectionFilter();
        $typeFilter = new TaxonomyTypeCollectionFilter(['curriculum-topic', 'curriculum-topic-folder']);
        $chain      = new FilterChain();
        $chain->attach($notTrashed);
        $chain->attach($typeFilter);

        $terms = $chain->filter($terms);
        /* @var $term TaxonomyTermInterface */
        foreach ($terms as $term) {
            $result      = $this->toDocument($term);
            $container[] = $result;
        }
        return $container;
    }
}
