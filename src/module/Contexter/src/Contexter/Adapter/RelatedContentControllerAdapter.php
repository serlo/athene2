<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Contexter\Adapter;

use Instance\Entity\InstanceAwareInterface;
use RelatedContent\Controller\RelatedContentController;

class RelatedContentControllerAdapter extends AbstractAdapter
{
    /**
     * @return array
     */
    public function getProvidedParams()
    {
        $return = [];
        /* @var $controller RelatedContentController */
        $params     = $this->getRouteParams();
        $controller = $this->getAdaptee();
        $container  = $controller->getContainer($params['id']);
        if ($container instanceof InstanceAwareInterface) {
            $return['instance'] = $container->getInstance()->getName();
        }
        $return['id'] = $container->getId();
        return $return;
    }

    protected function isValidController($controller)
    {
        return $controller instanceof RelatedContentController;
    }
}
