<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event\Listener;

use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;

class RepositoryManagerListener extends AbstractListener
{
    /**
     * @var array
     */
    protected $listeners = [];

    public function attachShared(SharedEventManagerInterface $events)
    {
        $class = $this->getMonitoredClass();
        $events->attach($class, 'commit', [$this, 'onAddRevision'], 1);
        $events->attach($class, 'checkout', [$this, 'onCheckout'], -1);
        $events->attach($class, 'reject', [$this, 'onReject'], -1);
    }

    protected function getMonitoredClass()
    {
        return 'Versioning\RepositoryManager';
    }

    public function onAddRevision(Event $e)
    {
        $repository = $e->getParam('repository');
        $revision   = $e->getParam('revision');
        $instance   = $repository->getInstance();

        $this->logEvent(
            'entity/revision/add',
            $instance,
            $revision,
            [
                [
                    'name'  => 'repository',
                    'value' => $repository
                ]
            ]
        );
    }

    public function onCheckout(Event $e)
    {
        $revision   = $e->getParam('revision');
        $repository = $e->getParam('repository');
        $reason     = $e->getParam('reason');
        $instance   = $repository->getInstance();

        $this->logEvent(
            'entity/revision/checkout',
            $instance,
            $revision,
            [
                [
                    'name'  => 'repository',
                    'value' => $repository
                ],
                [
                    'name'  => 'reason',
                    'value' => $reason
                ]
            ]
        );
    }

    public function onReject(Event $e)
    {
        $revision   = $e->getParam('revision');
        $repository = $e->getParam('repository');
        $instance   = $repository->getInstance();
        $reason     = $e->getParam('reason');

        $this->logEvent(
            'entity/revision/reject',
            $instance,
            $revision,
            [
                [
                    'name'  => 'repository',
                    'value' => $repository
                ],
                [
                    'name'  => 'reason',
                    'value' => $reason
                ]
            ]
        );
    }
}
