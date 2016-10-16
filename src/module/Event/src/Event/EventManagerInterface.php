<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event;

use Doctrine\Common\Collections\Collection;
use Event\Entity\EventInterface;
use Event\Entity\EventLogInterface;
use Instance\Entity\InstanceInterface;
use User\Entity\UserInterface;
use Uuid\Entity\UuidInterface;
use Zend\Paginator\Paginator;

interface EventManagerInterface
{
    /**
     * @param int $userId
     * @return EventLogInterface[]|Collection
     */
    public function findEventsByActor($userId);

    /**
     * @param int $userId
     * @param int $page
     * @param int $limit
     * @return Paginator
     */
    public function findAllEventsByActor($userId, $page, $limit = 100);
    /**
     * @param int   $objectId
     * @param bool  $recursive
     * @param array $filter
     * @return EventLogInterface[]|Collection
     */
    public function findEventsByObject($objectId, $recursive = true, array $filter = []);

    /**
     * Finds an event by it's name
     *
     * @param string $eventName
     * @return EventInterface
     */
    public function findTypeByName($eventName);

    /**
     * @param int $id
     * @return EventLogInterface
     */
    public function getEvent($id);

    /**
     * @param UserInterface $user
     * @param array $names
     * @return EventLogInterface[]|Collection
     */
    public function findEventsByNamesAndActor(UserInterface $user, array $names);

    /**
     * @param int $page
     * @param int $limit
     * @return Paginator
     */
    public function findAll($page, $limit = 100);

    /**
     * @param string            $eventName
     * @param InstanceInterface $instance
     * @param UuidInterface     $uuid
     * @param array             $parameters
     * @return EventLogInterface
     */
    public function logEvent(
        $eventName,
        InstanceInterface $instance,
        UuidInterface $uuid,
        array $parameters = []
    );
}
