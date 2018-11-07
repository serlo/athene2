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

class DiscussionManagerListener extends AbstractListener
{
    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach(
            $this->getMonitoredClass(),
            'start',
            [
                $this,
                'onStartSubscribe',
            ],
            2
        );

        $events->attach(
            $this->getMonitoredClass(),
            'comment',
            [
                $this,
                'onCommentSubscribe',
            ],
            2
        );
    }

    protected function getMonitoredClass()
    {
        return 'Discussion\DiscussionManager';
    }

    public function onCommentSubscribe(Event $e)
    {
        if (isset($e->getParam('data')['subscription'])) {
            $params = $e->getParam('data');
            $param  = $params['subscription'];
            if ($param['subscribe'] === '1') {
                $user          = $e->getParam('author');
                $discussion    = $e->getParam('discussion');
                $comment       = $e->getParam('comment');
                $notifyMailman = $param['mailman'] === '1' ? true : false;

                $this->subscribe($user, $discussion, $notifyMailman); // We want to subscribe to the discussion
                $this->subscribe(
                    $user,
                    $comment,
                    $notifyMailman
                ); // And also to the comment for e.g. listening on likes
            }
        }
    }

    public function onStartSubscribe(Event $e)
    {
        if (isset($e->getParam('data')['subscription'])) {
            $params = $e->getParam('data');
            $param  = $params['subscription'];
            if ($param['subscribe'] === '1') {
                $user          = $e->getParam('author');
                $discussion    = $e->getParam('discussion');
                $notifyMailman = $param['mailman'] === '1' ? true : false;
                $this->subscribe($user, $discussion, $notifyMailman);
            }
        }
    }
}
