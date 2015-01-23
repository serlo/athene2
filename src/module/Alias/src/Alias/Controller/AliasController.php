<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Alias\Controller;

use Alias\Exception\AliasNotFoundException;
use Alias\Exception\CanonicalUrlNotFoundException;
use Alias;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ArrayUtils;

class AliasController extends AbstractActionController
{
    use Alias\AliasManagerAwareTrait, \Instance\Manager\InstanceManagerAwareTrait;

    /**
     * @var unknown
     */
    protected $router;

    public function forwardAction()
    {
        $alias    = $this->params('alias');
        $instance = $this->getInstanceManager()->getInstanceFromRequest();

        try {
            $location = $this->aliasManager->findCanonicalAlias($alias, $instance);
            $this->redirect()->toUrl($location);
            $this->getResponse()->setStatusCode(301);
            return false;
        } catch (CanonicalUrlNotFoundException $e) {
        }

        try {
            $source = $this->aliasManager->findSourceByAlias($alias);
        } catch (AliasNotFoundException $e) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $router  = $this->getServiceLocator()->get('Router');
        $request = new Request();
        $request->setMethod(Request::METHOD_GET);
        $request->setUri($source);
        $routeMatch = $router->match($request);

        if ($routeMatch === null) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $this->getEvent()->setRouteMatch($routeMatch);
        $params     = $routeMatch->getParams();
        $controller = $params['controller'];
        $return     = $this->forward()->dispatch(
            $controller,
            ArrayUtils::merge(
                $params,
                [
                    'forwarded' => true
                ]
            )
        );

        return $return;
    }
}
