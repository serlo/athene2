<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Controller;

use Entity\Entity\EntityInterface;
use Entity\Exception\EntityNotFoundException;
use Entity\Manager\EntityManagerAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractController extends AbstractActionController
{
    use EntityManagerAwareTrait;

    /**
     * @param int  $id
     * @return EntityInterface
     */
    public function getEntity($id = null)
    {
        $id = null !== $id ? $id : $this->params('entity');
        try {
            $entity = $this->getEntityManager()->getEntity($id);
            return $entity;
        } catch (EntityNotFoundException $e) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }
    }
}
