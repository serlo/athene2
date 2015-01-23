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

use Instance\Manager\InstanceManagerAwareTrait;
use Link\Service\LinkServiceAwareTrait;
use Taxonomy\Controller\AbstractController;
use Taxonomy\Entity\TaxonomyTermInterface;

/**
 * Class TaxonomyTermControllerAdapter
 *
 * @package Contexter\Adapter
 */
class TaxonomyTermControllerAdapter extends AbstractAdapter
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
        $entity     = $controller->getTerm($params['term']);
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
     * @param TaxonomyTermInterface $term
     * @param array                 $array
     */
    protected function retrieveTerms(TaxonomyTermInterface $term, array &$array)
    {
        while ($term->hasParent()) {
            $name           = $term->getTaxonomy()->getName();
            $array[$name][] = $term->getName();
            $term           = $term->getParent();
        }
    }
}
