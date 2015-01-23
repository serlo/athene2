<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Normalizer\Controller;

use Attachment\Entity\Container;
use Discussion\Entity\CommentInterface;
use Entity\Entity\EntityInterface;
use Normalizer\Exception\RuntimeException;
use Normalizer\NormalizerAwareTrait;
use Taxonomy\Entity\TaxonomyTermInterface;
use Uuid\Exception\NotFoundException;
use Uuid\Manager\UuidManagerAwareTrait;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class SignpostController extends AbstractActionController
{
    use NormalizerAwareTrait, UuidManagerAwareTrait;

    public function indexAction()
    {
        try {
            $object = $this->getUuidManager()->getUuid($this->params('uuid'), true);
        } catch (NotFoundException $e) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $normalized  = $this->getNormalizer()->normalize($object);
        $routeName   = $normalized->getRouteName();
        $routeParams = $normalized->getRouteParams();
        $type        = $normalized->getType();
        $url         = $this->url()->fromRoute($routeName, $routeParams, null, null, false);

        if (!$this->getRequest()->isXmlHttpRequest()) {
            $url      = $this->url()->fromRoute($routeName, $routeParams);
            $response = $this->redirect()->toUrl($url);
            $this->getResponse()->setStatusCode(301);
            return $response;
        }

        $router  = $this->getServiceLocator()->get('Router');
        $request = new Request();
        $request->setMethod(Request::METHOD_GET);
        $request->setUri($url);
        $routeMatch = $router->match($request);

        if (!$routeMatch) {
            throw new RuntimeException(sprintf(
                'Could not match a route for `%s`',
                $url
            ));
        }

        $params     = array_merge($routeMatch->getParams(), ['forwarded' => true, 'isXmlHttpRequest' => true]);
        $controller = $params['controller'];
        $response   = $this->forward()->dispatch($controller, $params);

        // TODO: Do me a favor and remove this piece of cr*p with something that doesn't hack the whole thing
        if ($response instanceof JsonModel) {
            $response = new ViewModel(['data' => $response->getVariables()]);
            $response->setTemplate('normalizer/json');
        }

        $view = new ViewModel([
            'id'                        => $object->getId(),
            'type'                      => $type,
            'url'                       => $url,
            '__disableTemplateDebugger' => true
        ]);

        $view->addChild($response, 'response');
        $view->setTemplate('normalizer/ref');
        $view->setTerminal(true);
        return $view;
    }

    public function metaAction()
    {
        $object = $this->getUuidManager()->getUuid($this->params('id'), false);

        if($object instanceof EntityInterface) {
            $type = 'entity';
        } elseif ($object instanceof Container) {
            $type = 'attachment';
        } elseif ($object instanceof CommentInterface) {
            $type = 'comment';
        } elseif ($object instanceof TaxonomyTermInterface) {
            $type = 'taxonomyTerm';
        } else {
            $type = 'Could not detect type';
        }

        return new JsonModel([
            'id' => $object->getId(),
            'type' => $type
        ]);
    }

    public function refAction()
    {
        $this->redirect()->toRoute('uuid/get', ['uuid' => $this->params('object')]);
        $this->getResponse()->setStatusCode(301);
        return false;
    }
}
