<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
