<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Taxonomy\Listener;

use Common\Listener\AbstractSharedListenerAggregate;
use Taxonomy\Manager\TaxonomyManagerAwareTrait;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;

class EntityManagerListener extends AbstractSharedListenerAggregate
{
    use TaxonomyManagerAwareTrait;

    public function onCreate(Event $e)
    {
        $entity = $e->getParam('entity');
        $data   = $e->getParam('data');

        if (array_key_exists('taxonomy', $data)) {
            $options = $data['taxonomy'];
            $this->getTaxonomyManager()->associateWith($options['term'], $entity);
        }
    }

    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach($this->getMonitoredClass(), 'create', [$this, 'onCreate'], 2);
    }

    protected function getMonitoredClass()
    {
        return 'Entity\Manager\EntityManager';
    }
}
