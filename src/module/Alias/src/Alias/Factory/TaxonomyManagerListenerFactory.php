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
use Zend\ServiceManager\ServiceLocatorInterface;

class TaxonomyManagerListenerFactory extends AbstractListenerFactory
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return AbstractListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $aliasManager = $this->getAliasManager($serviceLocator);
        $listener     = $this->getClassName();
        $normalizer   = $serviceLocator->get('Normalizer\Normalizer');

        return new $listener($aliasManager, $normalizer);
    }

    protected function getClassName()
    {
        return 'Alias\Listener\TaxonomyManagerListener';
    }
}
