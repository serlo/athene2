<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event;

/**
 * Makes your class EventManagerAware
 */
trait EventManagerAwareTrait
{

    /**
     * The EventManager
     *
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * Gets the EventManager
     *
     * @return EventManagerInterface $eventManager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * Sets the EventManager
     *
     * @param EventManagerInterface $eventManager
     * @return self
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;

        return $this;
    }
}
