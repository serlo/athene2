<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Page\Factory;


use Page\Assertion\PageAssertion;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PageAssertionFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Rbac\Traversal\Strategy\TraversalStrategyInterface $traversalStrategy */
        $traversalStrategy = $serviceLocator->getServiceLocator()->get('Rbac\Rbac')->getTraversalStrategy();
        $assertion         = new PageAssertion($traversalStrategy);
        return $assertion;
    }
}
