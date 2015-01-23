<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
