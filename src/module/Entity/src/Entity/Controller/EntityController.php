<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Controller;

use Entity\Result;
use Instance\Manager\InstanceManagerAwareTrait;
use Zend\EventManager\ResponseCollection;

class EntityController extends AbstractController
{
    use InstanceManagerAwareTrait;

    public function createAction()
    {
        // No assertion necessary, because no view. This is done in the manager logic
        $type     = $this->params('type');
        $instance = $this->getInstanceManager()->getInstanceFromRequest();
        $query    = $this->params()->fromQuery();
        $entity   = $this->getEntityManager()->createEntity(
            $type,
            $query,
            $instance
        );
        $this->getEntityManager()->flush();

        $data     = ['entity' => $entity, 'data' => $query];
        $response = $this->getEventManager()->trigger('create.postFlush', $this, $data);
        return $this->checkResponse($response);
    }

    public function checkResponse(ResponseCollection $response)
    {
        $redirected = false;
        foreach ($response as $result) {
            if ($result instanceof Result\UrlResult) {
                $this->redirect()->toUrl($result->getResult());
                $redirected = true;
            }
        }

        if (!$redirected) {
            return $this->redirect()->toReferer();
        }
        return true;
    }
}
