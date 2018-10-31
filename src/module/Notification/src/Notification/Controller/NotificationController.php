<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification\Controller;

use Notification\NotificationManagerAwareTrait;
use Notification\NotificationManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZfcRbac\Service\AuthorizationService;

class NotificationController extends AbstractActionController
{
    use NotificationManagerAwareTrait;

    /**
     * @var \ZfcRbac\Service\AuthorizationService
     */
    protected $authorizationService;

    public function __construct(
        NotificationManagerInterface $notificationManager,
        AuthorizationService $authorizationService
    ) {
        $this->notificationManager  = $notificationManager;
        $this->authorizationService = $authorizationService;
    }

    public function readAction()
    {
        $user = $this->authorizationService->getIdentity();
        if ($user) {
            $this->notificationManager->markRead($user);
            $this->notificationManager->flush();
        }
        return new JsonModel([]);
    }
}
