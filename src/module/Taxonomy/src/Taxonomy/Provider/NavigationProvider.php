<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Taxonomy\Provider;

use Common\Traits\ObjectManagerAwareTrait;
use Doctrine\Common\Persistence\ObjectManager;
use Instance\Manager\InstanceManagerAwareTrait;
use Instance\Manager\InstanceManagerInterface;
use Navigation\Provider\PageProviderInterface;
use Taxonomy\Entity\TaxonomyTermInterface;
use Taxonomy\Manager\TaxonomyManagerAwareTrait;
use Taxonomy\Manager\TaxonomyManagerInterface;
use Uuid\Filter\NotTrashedCollectionFilter;
use Zend\Cache\Storage\StorageInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\Stdlib\ArrayUtils;

class NavigationProvider implements PageProviderInterface
{
    use TaxonomyManagerAwareTrait;
    use ObjectManagerAwareTrait, InstanceManagerAwareTrait;

    /**
     * @var array
     */
    protected $defaultOptions = [
        'name'       => 'default',
        'route'      => 'default',
        'parent'     => [
            'type' => '',
            'slug' => '',
        ],
        'instance'   => 'de',
        'max_depth'  => 1,
        'types'      => [],
        'params'     => [],
        'hidden'     => [],
        'identifier' => 'term',
    ];
    /**
     * @var array
     */
    protected $options;
    /**
     * @var StorageInterface
     */
    protected $storage;
    /**
     * @var TaxonomyTermInterface
     */
    protected $term;

    /**
     * @var NotTrashedCollectionFilter
     */
    protected $filter;

    /**
     * @param InstanceManagerInterface $instanceManager
     * @param TaxonomyManagerInterface $taxonomyManager
     * @param ObjectManager            $objectManager
     * @param StorageInterface         $storage
     */
    public function __construct(
        InstanceManagerInterface $instanceManager,
        TaxonomyManagerInterface $taxonomyManager,
        ObjectManager $objectManager,
        StorageInterface $storage
    ) {
        $this->instanceManager = $instanceManager;
        $this->taxonomyManager = $taxonomyManager;
        $this->objectManager   = $objectManager;
        $this->storage         = $storage;
        $this->filter = new NotTrashedCollectionFilter();
    }

    /**
     * @return TaxonomyTermInterface
     */
    public function getTerm()
    {
        if (!is_object($this->term)) {
            $instance   = $this->getInstanceManager()->findInstanceByName($this->options['instance']);
            $parent     = $this->options['parent'];
            $taxonomy   = $this->getTaxonomyManager()->findTaxonomyByName($parent['type'], $instance);
            $this->term = $this->getTaxonomyManager()->findTermByName($taxonomy, (array)$parent['slug']);
        }

        return $this->term;
    }

    /**
     * @param array $options
     * @return array
     */
    public function provide(array $options)
    {
        $this->options          = ArrayUtils::merge($this->defaultOptions, $options);
        $key                    = hash('sha256', serialize($this->options));
        $this->options['types'] = ArrayUtils::merge($this->options['types'], $this->options['hidden']);

        if ($this->storage->hasItem($key)) {
            return $this->storage->getItem($key);
        }

        $term = $this->getTerm();

        if ($this->getObjectManager()->isOpen()) {
            $this->getObjectManager()->refresh($term);
        }

        $terms      = $term->findChildrenByTaxonomyNames($this->options['types']);
        $pages      = $this->iterTerms($terms, $this->options['max_depth']);
        $this->term = null;
        $this->storage->setItem($key, $pages);

        return $pages;
    }

    /**
     * @param TaxonomyTermInterface[] $terms
     * @param int                     $depth
     * @return array
     */
    protected function iterTerms($terms, $depth)
    {
        if ($depth < 1) {
            return [];
        }

        $return = [];
        foreach ($terms as $term) {
            if (!$term->isTrashed()) {
                $current             = [];
                $current['route']    = $this->options['route'];
                $current['params'] = [$this->options['identifier'] => (string)$term->getId()];
                $current['label']    = $term->getName();
                $current['elements'] = $term->countAssociations(null, $this->filter);
                $children            = $term->findChildrenByTaxonomyNames($this->options['types']);
                if (in_array($term->getType()->getName(), $this->options['hidden'])) {
                    $current['visible'] = false;
                }
                if (count($children)) {
                    $current['pages'] = $this->iterTerms($children, $depth - 1);
                }
                $return[] = $current;
            }
        }
        return $return;
    }
}
