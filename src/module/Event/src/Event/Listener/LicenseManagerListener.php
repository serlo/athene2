<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event\Listener;

use Instance\Entity\InstanceProviderInterface;
use Uuid\Entity\UuidInterface;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;

class LicenseManagerListener extends AbstractListener
{
    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach($this->getMonitoredClass(), 'inject', [$this, 'onInject']);
    }

    protected function getMonitoredClass()
    {
        return 'License\Manager\LicenseManager';
    }

    public function onInject(Event $e)
    {
        $object = $e->getParam('object');
        if ($object instanceof InstanceProviderInterface && $object instanceof UuidInterface) {
            $this->logEvent('license/object/set', $object->getInstance(), $object);
        }
    }
}
