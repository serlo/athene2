<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Search\Listener;

use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Taxonomy\Entity\TaxonomyTermInterface;

class TaxonomyManagerListener extends AbstractListener
{

    /**
     * {@inheritDoc}
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach($this->getMonitoredClass(), 'update', [$this, 'onUpdate']);
        $events->attach($this->getMonitoredClass(), 'create', [$this, 'onCreate']);
    }

    /**
     * @param Event $e
     * @return void
     */
    public function onUpdate(Event $e)
    {
        /* @var $term TaxonomyTermInterface */
        $term = $e->getParam('term');

        if ($term instanceof TaxonomyTermInterface) {
            $this->searchService->add($term);
            $this->searchService->flush();
        }
    }

    /**
     * @param Event $e
     * @return void
     */
    public function onCreate(Event $e)
    {
        /* @var $term TaxonomyTermInterface */
        $term = $e->getParam('term');

        if ($term instanceof TaxonomyTermInterface) {
            $this->searchService->add($term);
            $this->searchService->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function getMonitoredClass()
    {
        return 'Taxonomy\Manager\TaxonomyManager';
    }
}
