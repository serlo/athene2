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
namespace Alias\Listener;

use Alias\AliasManagerInterface;
use Normalizer\NormalizerInterface;
use Taxonomy\Entity\TaxonomyTermInterface;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;

class TaxonomyManagerListener extends AbstractListener
{
    /**
     * @var NormalizerInterface
     */
    protected $normalizer;

    /**
     * @param AliasManagerInterface $aliasManager
     * @param NormalizerInterface   $normalizer
     */
    public function __construct(AliasManagerInterface $aliasManager, NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
        parent::__construct($aliasManager);
    }

    /**
     * Attach one or more listeners
     * Implementors may add an optional $priority argument; the SharedEventManager
     * implementation will pass this to the aggregate.
     *
     * @param SharedEventManagerInterface $events
     * @return void
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $class = $this->getMonitoredClass();
        $events->attach($class, 'create', [$this, 'doAliases']);
        $events->attach($class, 'update', [$this, 'doAliases']);
    }

    /**
     * @param Event $e
     * @return void
     */
    public function doAliases(Event $e)
    {
        /* @var $term TaxonomyTermInterface */
        $term = $e->getParam('term');
        $this->process($term);
    }

    /**
     * Returns the class, this listener is listening on
     *
     * @return string
     */
    protected function getMonitoredClass()
    {
        return 'Taxonomy\Manager\TaxonomyManager';
    }

    protected function process(TaxonomyTermInterface $term)
    {
        if(!$term->hasParent()){
            return;
        }

        if ($term->getId() === null) {
            $this->getAliasManager()->flush($term);
        }

        $instance    = $term->getInstance();
        $normalizer  = $this->normalizer->normalize($term);
        $routeName   = $normalizer->getRouteName();
        $routeParams = $normalizer->getRouteParams();
        $router      = $this->getAliasManager()->getRouter();
        $url         = $router->assemble($routeParams, ['name' => $routeName]);
        $this->getAliasManager()->autoAlias('taxonomyTerm', $url, $term, $instance);

        foreach ($term->getChildren() as $child) {
            $this->process($child);
        }
    }
}
