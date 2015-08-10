<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification\Controller;

use Notification\NotificationWorker;
use Zend\Mvc\Controller\AbstractConsoleController;

class WorkerController extends AbstractConsoleController
{

    /**
     * @var NotificationWorker
     */
    protected $notificationWorker;

    /**
     * @return NotificationWorker $notificationWorker
     */
    public function getNotificationWorker()
    {
        return $this->notificationWorker;
    }

    /**
     * @param NotificationWorker $notificationWorker
     * @return self
     */
    public function setNotificationWorker(NotificationWorker $notificationWorker)
    {
        $this->notificationWorker = $notificationWorker;
    }

    public function runAction()
    {
        $this->getNotificationWorker()->run();
        $this->getNotificationWorker()->getObjectManager()->flush();
        return 'success';
    }
}
