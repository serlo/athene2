<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Instance\Listener;

use Common\Listener\AbstractSharedListenerAggregate;
use Instance\Entity\InstanceProviderInterface;
use Instance\Exception;
use Instance\Manager\InstanceManagerInterface;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;

class IsolationBypassedListener extends AbstractSharedListenerAggregate
{

    protected $instanceManager;

    /**
     * @param InstanceManagerInterface $instanceManager
     */
    function __construct(InstanceManagerInterface $instanceManager)
    {
        $this->instanceManager = $instanceManager;
    }

    /**
     * @param SharedEventManagerInterface $events
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach(
            $this->getMonitoredClass(),
            'isolationBypassed',
            [
                $this,
                'onBypass'
            ],
            -1000
        );
    }

    /**
     * @param Event $e
     * @throws \Instance\Exception\RuntimeException
     */
    public function onBypass(Event $e)
    {
        $target = $e->getTarget();
        if (!$target instanceof InstanceProviderInterface) {
            throw new Exception\RuntimeException(sprintf(
                'Expected instance of InstanceProviderInterface but got %s.',
                is_object($target) ? get_class($target) : gettype($target)
            ));

        }

        $this->instanceManager->switchInstance($target->getInstance());
    }

    protected function getMonitoredClass()
    {
        return 'Instance\Manager\InstanceAwareEntityManager';
    }
}
