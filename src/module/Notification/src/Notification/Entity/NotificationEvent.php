<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
namespace Notification\Entity;

use Doctrine\ORM\Mapping as ORM;
use Event\Entity\EventLogInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="notification_event")
 */
class NotificationEvent implements NotificationEventInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="Event\Entity\EventLog")
     * @ORM\JoinColumn(name="event_log_id", referencedColumnName="id")
     */
    protected $eventLog;

    /**
     * @ORM\OneToOne(targetEntity="Notification")
     * @ORM\JoinColumn(name="notification_id", referencedColumnName="id")
     */
    protected $notification;

    /*
     * (non-PHPdoc) @see \User\Notification\Entity\NotificationEventInterface::getEventLog()
     */
    public function getEventLog()
    {
        return $this->eventLog;
    }

    /*
     * (non-PHPdoc) @see \User\Notification\Entity\NotificationEventInterface::setEventLog()
     */
    public function setEventLog(EventLogInterface $eventLog)
    {
        $this->eventLog = $eventLog;

        return $this;
    }

    /*
     * (non-PHPdoc) @see \User\Notification\Entity\NotificationEventInterface::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /*
     * (non-PHPdoc) @see \User\Notification\Entity\NotificationEventInterface::getNotification()
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /*
     * (non-PHPdoc) @see \User\Notification\Entity\NotificationEventInterface::setNotification()
     */
    public function setNotification(NotificationInterface $notification)
    {
        $this->notification = $notification;

        return $this;
    }
}
