<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Jakob Pfab (jakob.pfab@serlo.org)
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Page\Provider;

use Zend\Mvc\MvcEvent;

class FirewallHydrator
{

    use\Page\Manager\PageManagerAwareTrait;
    use\Zend\ServiceManager\ServiceLocatorAwareTrait;

    protected $event;

    public function __construct(MvcEvent $event)
    {
        $this->event = $event;
    }

    public function getRoles()
    {
        $this->setPageManager(
            $this->getServiceLocator()->get('Page\Manager\PageManager')
        );
        $routeMatch = $this->event->getRouteMatch();
        $id         = $routeMatch->getParam('page');
        if ($id === null) {
            $id = $routeMatch->getParam('id');
        }
        $pageRepository = $this->getPageManager()->getPageRepository($id);

        $allRoles = $this->getPageManager()->findAllRoles();
        $array    = [];

        foreach ($allRoles as $role) {
            if ($pageRepository->hasRole($role)) {
                $array[] = $role->getName();
            }
        }

        return $array;
    }
}
