<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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