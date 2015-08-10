<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Common\Listener;

use Zend\EventManager\SharedListenerAggregateInterface;

abstract class AbstractSharedListenerAggregate implements SharedListenerAggregateInterface
{

    /**
     * An array containing all registered listeners.
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * Returns the class, this listener is listening on
     *
     * @return string
     */
    abstract protected function getMonitoredClass();

    public function detachShared(\Zend\EventManager\SharedEventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($this->getMonitoredClass(), $listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}
