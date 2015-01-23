<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Search\Listener;

use Entity\Entity\EntityInterface;
use Taxonomy\Entity\TaxonomyTermInterface;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;

class UuidManagerListener extends AbstractListener
{
    /**
     * {@inheritDoc}
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach($this->getMonitoredClass(), 'trash', [$this, 'onDelete']);
        $events->attach($this->getMonitoredClass(), 'purge', [$this, 'onDelete']);
        $events->attach($this->getMonitoredClass(), 'restore', [$this, 'onRestore']);
    }

    /**
     * @param Event $e
     * @return void
     */
    public function onRestore(Event $e)
    {
        $object = $e->getParam('object');

        if ($object instanceof EntityInterface || $object instanceof TaxonomyTermInterface) {
            $this->searchService->add($object);
        }

        $this->searchService->flush();
    }

    /**
     * @param Event $e
     * @return void
     */
    public function onDelete(Event $e)
    {
        $object = $e->getParam('object');

        if ($object instanceof EntityInterface || $object instanceof TaxonomyTermInterface) {
            $this->searchService->delete($object);
        }

        $this->searchService->flush();
    }

    /**
     * {@inheritDoc}
     */
    protected function getMonitoredClass()
    {
        return 'Uuid\Manager\UuidManager';
    }
}
