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
namespace CacheInvalidator\Invalidator;

use StrokerCache\Service\CacheService;
use Taxonomy\Entity\TaxonomyTermInterface;
use Zend\Cache\Storage\FlushableInterface;
use Zend\Cache\Storage\StorageInterface;
use Zend\EventManager\Event;

class TaxonomyStorageInvalidator implements InvalidatorInterface
{

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var CacheService
     */
    protected $cacheService;


    /**
     * @param CacheService     $cacheService
     * @param StorageInterface $storage
     */
    public function __construct(CacheService $cacheService, StorageInterface $storage)
    {
        $this->storage      = $storage;
        $this->cacheService = $cacheService;
    }

    /**
     * @param Event  $e
     * @param string $class
     * @param string $event
     * @return void
     */
    public function invalidate(Event $e, $class, $event)
    {
        $term   = $e->getParam('term');
        $result = false;

        if ($term instanceof TaxonomyTermInterface) {
            $result = $this->cacheService->clearByTags(['route_taxonomy/term/get', 'param_term_' . $term->getId()]);
            $this->cacheService->clearByTags(['navigation/render']);
            $this->clearParents($term);
        }

        if ($this->storage instanceof FlushableInterface && !$result) {
            $this->storage->flush();
        }
    }

    protected function clearParents(TaxonomyTermInterface $term)
    {
        if ($term->hasParent()) {
            $parent = $term->getParent();
            $this->cacheService->clearByTags(['route_taxonomy/term/get', 'param_term_' . $parent->getId()]);
            $this->clearParents($parent);
        }
    }
}
