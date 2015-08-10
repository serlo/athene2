<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification\Entity;

use Event\Entity\EventLogInterface;

interface NotificationEventInterface
{

    /**
     * @return EventLogInterface
     */
    public function getEventLog();

    /**
     * @param EventLogInterface $eventLog
     * @return self;
     */
    public function setEventLog(EventLogInterface $eventLog);

    /**
     * @return int
     */
    public function getId();

    /**
     * @return NotificationInterface
     */
    public function getNotification();

    /**
     * @param NotificationInterface $notification
     * @return self
     */
    public function setNotification(NotificationInterface $notification);
}
