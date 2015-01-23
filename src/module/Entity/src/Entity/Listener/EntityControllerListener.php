<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Listener;

use Common\Listener\AbstractSharedListenerAggregate;
use Entity\Result\UrlResult;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;

class EntityControllerListener extends AbstractSharedListenerAggregate
{

    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach(
            $this->getMonitoredClass(),
            'create.postFlush',
            [
                $this,
                'onCreate'
            ],
            -1000
        );
    }

    protected function getMonitoredClass()
    {
        return 'Entity\Controller\EntityController';
    }

    public function onCreate(Event $e)
    {
        /* var $entity \Entity\Entity\EntityInterface */
        $entity = $e->getParam('entity');

        $result = new UrlResult();
        $result->setResult(
            $e->getTarget()->url()->fromRoute(
                'entity/repository/add-revision',
                [
                    'entity' => $entity->getId()
                ]
            )
        );

        return $result;
    }
}
