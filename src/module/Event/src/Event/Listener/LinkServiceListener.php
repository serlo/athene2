<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event\Listener;

use Zend\EventManager\Event;

class LinkServiceListener extends AbstractListener
{
    public function onLink(Event $e)
    {
        $entity   = $e->getParam('entity');
        $user     = $this->getUserManager()->getUserFromAuthenticator();
        $instance = $this->getInstanceManager()->getInstanceFromRequest();

        $params = [
            [
                'name'  => 'parent',
                'value' => $e->getParam('parent'),
            ],
        ];

        $this->logEvent('entity/link/create', $instance, $entity, $params);
    }

    public function onUnLink(Event $e)
    {
        $entity   = $e->getParam('entity');
        $user     = $this->getUserManager()->getUserFromAuthenticator();
        $instance = $this->getInstanceManager()->getInstanceFromRequest();

        $params = [
            [
                'name'  => 'parent',
                'value' => $e->getParam('parent'),
            ],
        ];

        $this->logEvent('entity/link/remove', $instance, $entity, $params);
    }

    public function attachShared(\Zend\EventManager\SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            $this->getMonitoredClass(),
            'unlink',
            [
                $this,
                'onUnlink',
            ]
        );

        $this->listeners[] = $events->attach(
            $this->getMonitoredClass(),
            'link',
            [
                $this,
                'onLink',
            ]
        );
    }

    protected function getMonitoredClass()
    {
        return 'Link\Service\LinkService';
    }
}
