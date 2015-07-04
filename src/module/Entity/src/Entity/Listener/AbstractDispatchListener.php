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
use Entity\Controller\AbstractController;
use Navigation\Factory\DefaultNavigationFactory;
use Taxonomy\Strategy\BranchDecisionMakerStrategy;
use Taxonomy\Strategy\ShortestBranchDecisionMaker;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

abstract class AbstractDispatchListener extends AbstractSharedListenerAggregate
{
    protected $strategy;

    public function __construct(BranchDecisionMakerStrategy $strategy = null)
    {
        if (!$strategy) {
            $strategy = new ShortestBranchDecisionMaker();
        }
        $this->strategy = $strategy;
    }

    public function attachShared(SharedEventManagerInterface $events)
    {
        $events->attach(
            $this->getMonitoredClass(),
            MvcEvent::EVENT_DISPATCH,
            [
                $this,
                'onDispatch'
            ]
        );
    }

    public function onDispatch(Event $event)
    {
        $controller = $event->getTarget();
        if (!$controller instanceof AbstractController) {
            return;
        }

        $entity = $controller->getEntity();
        if (!$entity) {
            return;
        }

        $terms = $entity->getTaxonomyTerms();

        if($terms->isEmpty()){
            foreach($entity->getParents('link') as $parent){
                $terms = $parent->getTaxonomyTerms();
                if(!$terms->isEmpty()) break;
            }
        }

        $term  = $this->strategy->findBranch($terms);

        if ($term) {
            /* @var $navigationFactory DefaultNavigationFactory */
            $navigationFactory = $controller->getServiceLocator()->get(
                'Navigation\Factory\DefaultNavigationFactory'
            );
            $params            = [
                'term'       => $term->getId(),
                'controller' => 'Taxonomy\Controller\GetController',
                'action'     => 'index'
            ];
            $routeMatch        = new RouteMatch($params);

            $routeMatch->setMatchedRouteName('taxonomy/term/get');
            $navigationFactory->setRouteMatch($routeMatch);
        }
    }
}
