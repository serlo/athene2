<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event\View\Helper;

use Event\Entity\EventLogInterface;
use Event\EventManagerAwareTrait;
use Event\EventManagerInterface;
use Event\Exception;
use User\Entity\UserInterface;
use Zend\View\Helper\AbstractHelper;

class EventLog extends AbstractHelper
{
    use EventManagerAwareTrait;

    /**
     * @var string
     */
    protected $eventsTemplate = 'event/helper/events';

    /**
     * @var string
     */
    protected $eventTemplate = 'event/helper/event/default';

    /**
     * @param EventManagerInterface $eventManager
     */
    public function __construct(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }

    public function renderEvent($id)
    {
        if (is_numeric($id)) {
            $event = $this->getEventManager()->getEvent($id);
        } elseif ($id instanceof EventLogInterface) {
            $event = $id;
        } else {
            throw new Exception\InvalidArgumentException(sprintf(
                'Expected numeric, EventLogInterface or EventServiceInterface but got `%s`',
                gettype($id)
            ));
        }

        return $this->getView()->partial($this->eventTemplate, ['event' => $event]);
    }

    public function countEventsFoundByActorAndNames(UserInterface $user, array $names)
    {
        return $this->getEventManager()->findEventsByNamesAndActor($user, $names)->count();
    }

    public function renderObjectLog($id)
    {
        $events = $this->getEventManager()->findEventsByObject($id);
        return $this->getView()->partial($this->eventsTemplate, ['events' => $events]);
    }

    public function renderUserLog($id, $limit = 50)
    {
        $events = $this->getEventManager()->findEventsByActor($id, $limit);
        return $this->getView()->partial($this->eventsTemplate, ['events' => $events]);
    }
}
