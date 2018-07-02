<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Mailman\Listener;

use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\View\Model\ViewModel;

class UserControllerListener extends AbstractListener
{
    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach($this->getMonitoredClass(), 'register', [$this, 'onRegister'], -1);
    }

    protected function getMonitoredClass()
    {
        return 'User\Controller\UserController';
    }

    public function onRegister(Event $e)
    {
        /* @var $user \User\Entity\UserInterface */
        $user = $e->getParam('user');

        $subject = new ViewModel();
        $body    = new ViewModel([
            'user' => $user,
        ]);

        $subject->setTemplate('mailman/messages/register/subject');
        $body->setTemplate('mailman/messages/register/body');

        try {
            $this->getMailman()->send(
                $user->getEmail(),
                $this->getMailman()->getDefaultSender(),
                $this->getRenderer()->render($subject),
                $this->getRenderer()->render($body)
            );
        } catch (\Throwable $e) {
            // catch exception
        }
    }
}
