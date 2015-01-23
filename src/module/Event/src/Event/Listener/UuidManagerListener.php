<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event\Listener;

use Zend\EventManager\Event;

class UuidManagerListener extends AbstractListener
{

    public function onRestore(Event $e)
    {
        $object   = $e->getParam('object');
        $user     = $this->getUserManager()->getUserFromAuthenticator();
        $instance = $this->getInstanceManager()->getInstanceFromRequest();

        $this->logEvent('uuid/restore', $instance, $object);
    }

    public function onTrash(Event $e)
    {
        $object   = $e->getParam('object');
        $user     = $this->getUserManager()->getUserFromAuthenticator();
        $instance = $this->getInstanceManager()->getInstanceFromRequest();

        $this->logEvent('uuid/trash', $instance, $object);
    }

    public function attachShared(\Zend\EventManager\SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            $this->getMonitoredClass(),
            'trash',
            [
                $this,
                'onTrash'
            ]
        );
        $this->listeners[] = $events->attach(
            $this->getMonitoredClass(),
            'restore',
            [
                $this,
                'onRestore'
            ]
        );
    }

    protected function getMonitoredClass()
    {
        return 'Uuid\Manager\UuidManager';
    }
}
