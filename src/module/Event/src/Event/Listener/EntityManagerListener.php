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

class EntityManagerListener extends AbstractListener
{
    public function onCreate(Event $e)
    {
        $entity   = $e->getParam('entity');
        $user     = $this->getUserManager()->getUserFromAuthenticator();
        $instance = $this->getInstanceManager()->getInstanceFromRequest();

        $this->logEvent('entity/create', $instance, $entity);
    }

    public function attachShared(\Zend\EventManager\SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            $this->getMonitoredClass(),
            'create',
            [
                $this,
                'onCreate',
            ]
        );
    }

    protected function getMonitoredClass()
    {
        return 'Entity\Manager\EntityManager';
    }
}
