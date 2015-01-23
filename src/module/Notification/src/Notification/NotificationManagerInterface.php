<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification;

use Common\ObjectManager\Flushable;
use Doctrine\Common\Collections\ArrayCollection;
use Event\Entity\EventLogInterface;
use Notification\Entity\NotificationInterface;
use User\Entity\UserInterface;

interface NotificationManagerInterface extends Flushable
{

    /**
     * @param UserInterface     $user
     * @param EventLogInterface $eventLog
     * @return NotificationInterface
     */
    public function createNotification(UserInterface $user, EventLogInterface $eventLog);

    /**
     * @param UserInterface $user
     * @param int           $limit
     * @return ArrayCollection
     */
    public function findNotificationsBySubscriber(UserInterface $user, $limit = 20);

    /**
     * @param UserInterface $user
     * @return void
     */
    public function markRead(UserInterface $user);
}
