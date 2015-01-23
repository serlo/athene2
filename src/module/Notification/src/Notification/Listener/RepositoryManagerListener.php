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

class RepositoryManagerListener extends AbstractListener
{
    public function onCommitRevision(Event $e)
    {
        $repository = $e->getParam('repository');
        $data       = $e->getParam('data');
        $user       = $e->getParam('author');

        foreach ($data as $params) {
            if (is_array($params) && array_key_exists('subscription', $params)) {
                $param = $params['subscription'];
                if ($param['subscribe'] === '1') {
                    $notifyMailman = $param['mailman'] === '1' ? true : false;
                    $this->subscribe($user, $repository, $notifyMailman);
                }
            }
        }
    }

    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach(
            $this->getMonitoredClass(),
            'commit',
            [
                $this,
                'onCommitRevision'
            ],
            2
        );
    }

    protected function getMonitoredClass()
    {
        return 'Versioning\RepositoryManager';
    }
}
