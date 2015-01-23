<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
