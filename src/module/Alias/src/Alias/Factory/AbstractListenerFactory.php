<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Alias\Factory;

use Alias\Listener\AbstractListener;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractListenerFactory implements FactoryInterface
{
    use AliasManagerFactoryTrait;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return AbstractListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $aliasManager = $this->getAliasManager($serviceLocator);
        $listener     = $this->getClassName();

        return new $listener($aliasManager);
    }

    /**
     * @return string
     */
    abstract protected function getClassName();
}
