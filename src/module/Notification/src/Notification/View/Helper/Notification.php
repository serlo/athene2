<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification\View\Helper;

use Doctrine\Common\Collections\Collection;
use Notification\Entity\NotificationInterface;
use Notification\NotificationManagerInterface;
use User\Manager\UserManagerInterface;
use Zend\Cache\Storage\StorageInterface;
use Zend\View\Helper\AbstractHelper;
use ZfcTwig\View\TwigRenderer;

class Notification extends AbstractHelper
{
    protected $template;
    protected $aggregatedUsers;

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var NotificationManagerInterface
     */
    protected $notificationManager;

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @var TwigRenderer
     */
    protected $renderer;

    /**
     * @param NotificationManagerInterface $notificationManager
     * @param StorageInterface             $storage
     * @param TwigRenderer                 $renderer
     * @param UserManagerInterface         $userManager
     */
    public function __construct(
        NotificationManagerInterface $notificationManager,
        StorageInterface $storage,
        TwigRenderer $renderer,
        UserManagerInterface $userManager
    ) {
        $this->storage             = $storage;
        $this->notificationManager = $notificationManager;
        $this->userManager         = $userManager;
        $this->template = 'notification/notifications';
        $this->renderer = $renderer;
    }

    public function aggregateUsers(Collection $users)
    {
        $this->aggregatedUsers = [];
        foreach ($users as $actor) {
            if (!$actor instanceof \User\Entity\UserInterface) {
                throw new \User\Exception\RuntimeException(sprintf(
                    'Expected UserInterface but got %s',
                    gettype($actor)
                ));
            }

            if (!in_array($actor, $this->aggregatedUsers)) {
                $this->aggregatedUsers[] = $actor;
            }
        }

        return $this->aggregatedUsers;
    }

    public function getAggregatedUsernames()
    {
        $usernames = [];
        foreach ($this->aggregatedUsers as $user) {
            $usernames[] = $user->getUsername();
        }

        return implode(', ', $usernames);
    }

    public function getSeen(Collection $collection)
    {
        return $collection->filter(
            function (NotificationInterface $notification) {
                return !$notification->getSeen();
            }
        );
    }

    public function render($limit = 25)
    {
        $user   = $this->userManager->getUserFromAuthenticator();
        $key    = hash('sha256', serialize($user));
        $output = '';

        if ($this->storage->hasItem($key)) {
            //return $this->storage->getItem($key);
        }

        if ($user) {
            $notifications = $this->notificationManager->findNotificationsBySubscriber($user, $limit);
            $output        = $this->renderer->render($this->template, ['notifications' => $notifications]);
            $this->storage->setItem($key, $output);
        }

        return $output;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function __invoke()
    {
        return $this;
    }
}
