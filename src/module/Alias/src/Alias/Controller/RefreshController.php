<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Alias\Controller;

use Alias\AliasManagerInterface;
use Zend\Mvc\Controller\AbstractConsoleController;

/**
 * A controller for controlling the index.
 */
class RebuildController extends AbstractConsoleController
{
    /**
     * @var AliasManagerInterface
     */
    protected $aliasManager;

    /**
     * @param AliasManagerInterface $aliasManager
     */
    public function __construct(
        AliasManagerInterface $aliasManager
    ) {
        $this->aliasManager = $aliasManager;
    }

    public function rebuildAction()
    {



        $instance    = $term->getInstance();
        $normalizer  = $this->normalizer->normalize($term);
        $routeName   = $normalizer->getRouteName();
        $routeParams = $normalizer->getRouteParams();
        $router      = $this->getAliasManager()->getRouter();
        $url         = $router->assemble($routeParams, ['name' => $routeName]);
        $this->getAliasManager()->autoAlias('taxonomyTerm', $url, $term, $instance);



        $instance = $entity->getInstance();

        if ($entity->getId() === null) {
            $this->getAliasManager()->flush($entity);
        }

        $url = $this->getAliasManager()->getRouter()->assemble(
            ['entity' => $entity->getId()],
            ['name' => 'entity/page']
        );

        $this->getAliasManager()->autoAlias('entity', $url, $entity, $instance);




    }
}
