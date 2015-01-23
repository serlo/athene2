<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event\Controller;

use Event\EventManagerInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EventController extends AbstractActionController
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    public function __construct(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    public function historyAction()
    {
        $id   = $this->params('id');
        $events = $this->eventManager->findEventsByObject($id);

        if(empty($events)){
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $view = new ViewModel(['id' => $id, 'events' => $events]);
        $view->setTemplate('event/history/object');
        return $view;
    }

    public function allAction()
    {
        $page = $this->params()->fromQuery('page', 0);
        $paginator = $this->eventManager->findAll($page);
        $view = new ViewModel(['paginator' => $paginator]);
        $view->setTemplate('event/history/all');
        return $view;
    }
}
