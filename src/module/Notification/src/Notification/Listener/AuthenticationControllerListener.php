<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification\Listener;

use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use User\Entity\UserInterface;

class AuthenticationControllerListener extends AbstractListener
{
    public function onActivated(Event $e)
    {
        /* @var $user UserInterface */
        $user = $e->getParam('user');
        $this->subscribe($user, $user, true);
    }

    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach(
            $this->getMonitoredClass(),
            'activated',
            [
                $this,
                'onActivated'
            ]
        );
    }

    protected function getMonitoredClass()
    {
        return 'Authentication\Controller\AuthenticationController';
    }
}