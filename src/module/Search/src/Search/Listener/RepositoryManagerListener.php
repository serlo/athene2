<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Search\Listener;

use Entity\Entity\EntityInterface;
use Uuid\Manager\UuidManagerInterface;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Search\SearchServiceInterface;
use Versioning\RepositoryManagerInterface;
use Versioning\Entity\RepositoryInterface;

class RepositoryManagerListener extends AbstractListener
{
    /**
     * {@inheritDoc}
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach($this->getMonitoredClass(), 'checkout', [$this, 'onCheckout']);
    }

    /**
     * @param Event $e
     * @return void
     */
    public function onCheckout(Event $e)
    {
        /* @var $repository RepositoryInterface */
        $repository = $e->getParam('repository');

        if ($repository instanceof EntityInterface) {
            $this->searchService->add($repository);
            $this->searchService->flush();
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function getMonitoredClass()
    {
        return 'Versioning\RepositoryManager';
    }
}
