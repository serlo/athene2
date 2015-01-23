<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Contexter\Adapter;

use Entity\Controller\AbstractController;
use Entity\Entity\EntityInterface;
use Instance\Manager\InstanceManagerAwareTrait;
use Link\Service\LinkServiceAwareTrait;

/**
 * Class EntityControllerAdapter
 *
 * @package Contexter\Adapter
 *          @method
 */
class EntityControllerAdapter extends AbstractAdapter
{
    use InstanceManagerAwareTrait, LinkServiceAwareTrait;

    /**
     * @return array
     */
    public function getProvidedParams()
    {
        /* @var $controller AbstractController */
        $params     = $this->getRouteParams();
        $controller = $this->getAdaptee();
        $entity     = $controller->getEntity($params['entity']);
        $array      = [
            'type'     => $entity->getType()->getName(),
            'instance' => $entity->getInstance()->getName()
        ];

        $this->retrieveTerms($entity, $array);

        return $array;
    }

    /**
     * @param object $controller
     * @return bool
     */
    public function isValidController($controller)
    {
        return $controller instanceof AbstractController;
    }

    /**
     * @param EntityInterface $entity
     * @param array           $array
     */
    protected function retrieveTerms(EntityInterface $entity, array &$array)
    {
        foreach ($entity->getTaxonomyTerms() as $term) {
            while ($term->hasParent()) {
                $name           = $term->getTaxonomy()->getName();
                $array[$name][] = $term->getName();
                $term           = $term->getParent();
            }
        }

        $this->retrieveTermsThroughParents($entity, $array);
    }

    /**
     * @todo improve logic
     * @param EntityInterface $entity
     * @param array           $array
     */
    protected function retrieveTermsThroughParents(EntityInterface $entity, array &$array)
    {
        foreach ($entity->getParentLinks() as $link) {
            if ($link->getType()->getName() == 'link') {
                /* @var $parent EntityInterface */
                $parent = $link->getParent();
                $this->retrieveTerms($parent, $array);
            }
        }
    }
}
