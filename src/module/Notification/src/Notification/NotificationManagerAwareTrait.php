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

trait NotificationManagerAwareTrait
{

    /**
     * @var NotificationManagerInterface
     */
    protected $notificationManager;

    /**
     * @return NotificationManagerInterface $notificationManager
     */
    public function getNotificationManager()
    {
        return $this->notificationManager;
    }

    /**
     * @param NotificationManagerInterface $notificationManager
     * @return self
     */
    public function setNotificationManager(NotificationManagerInterface $notificationManager)
    {
        $this->notificationManager = $notificationManager;

        return $this;
    }
}
