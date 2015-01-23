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
namespace Taxonomy\Controller;

use Taxonomy\Entity\TaxonomyTermInterface;
use Zend\View\Model\JsonModel;

class ApiController extends AbstractController
{
    public function typesAction()
    {
        $instance   = $this->getInstanceManager()->getInstanceFromRequest();
        $taxonomies = $this->getTaxonomyManager()->findAllTaxonomies($instance);
        $data       = [];
        foreach ($taxonomies as $taxonomy) {
            $data[] = [
                'name'     => $taxonomy->getName(),
                'instance' => $taxonomy->getInstance()->getId(),
                'id'       => $taxonomy->getId(),
            ];
        }
        $view = new JsonModel($data);
        return $view;
    }

    public function typeAction()
    {
        $type     = $this->params('type');
        $instance = $this->getInstanceManager()->getInstanceFromRequest();
        $taxonomy = $this->getTaxonomyManager()->findTaxonomyByName($type, $instance);
        $data     = [
            'name'     => $taxonomy->getName(),
            'instance' => $taxonomy->getInstance()->getId(),
            'id'       => $taxonomy->getId(),
        ];
        $view     = new JsonModel($data);
        return $view;
    }

    public function termsAction()
    {
        $type     = $this->params('type');
        $instance = $this->getInstanceManager()->getInstanceFromRequest();
        $taxonomy = $this->getTaxonomyManager()->findTaxonomyByName($type, $instance);
        $data     = [];
        foreach ($taxonomy->getTerms() as $term) {
            $data[] = $this->ajaxify($term);
        }
        $view = new JsonModel($data);
        return $view;
    }

    public function termAction()
    {
        $type     = $this->params('id');
        $taxonomy = $this->getTaxonomyManager()->getTerm($type);
        $view     = new JsonModel($this->ajaxify($taxonomy));
        return $view;
    }

    public function saplingsAction()
    {
        $type     = $this->params('type');
        $instance = $this->getInstanceManager()->getInstanceFromRequest();
        $taxonomy = $this->getTaxonomyManager()->findTaxonomyByName($type, $instance);
        $data     = [];
        foreach ($taxonomy->getChildren() as $term) {
            $data[] = $this->ajaxify($term);
        }
        $view = new JsonModel($data);
        return $view;
    }

    protected function ajaxify(TaxonomyTermInterface $term)
    {
        $data = [
            'id'           => $term->getId(),
            'name'         => $term->getName(),
            'taxonomy'     => $term->getTaxonomy()->getId(),
            'url'          => $this->url()->fromRoute('uuid/get', ['uuid' => $term->getId()]),
            'parent'       => $term->hasParent() ? $term->getParent()->getId() : null,
            'children'     => [],
            'items'        => []
        ];

        foreach ($term->getChildren() as $child) {
            $data['children'][] = $this->ajaxify($child);
        }

        foreach ($term->getAssociated('entities') as $child) {
            $data['children'][] = [
                'id'   => $child->getId(),
                'type' => 'entity'
            ];
        }

        return $data;
    }
}
