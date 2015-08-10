<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Alias\Listener;

use Alias\AliasManagerAwareTrait;
use Entity\Entity\EntityInterface;
use Instance\Manager\InstanceManagerAwareTrait;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;

class RepositoryManagerListener extends AbstractListener
{
    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach($this->getMonitoredClass(), 'checkout', [$this, 'onCheckout']);
    }

    protected function getMonitoredClass()
    {
        return 'Versioning\RepositoryManager';
    }

    public function onCheckout(Event $e)
    {
        $entity = $e->getParam('repository');

        if ($entity instanceof EntityInterface) {
            $instance = $entity->getInstance();

            if ($entity->getId() === null) {
                $this->getAliasManager()->flush($entity);
            }

            $url = $this->getAliasManager()->getRouter()->assemble(
                ['entity' => $entity->getId()],
                ['name' => 'entity/page']
            );

            $this->getAliasManager()->autoAlias('entity', $url, $entity, $instance);
        }
    }
}
