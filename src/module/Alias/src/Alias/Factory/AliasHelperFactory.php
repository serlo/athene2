<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Alias\Factory;


use Alias\View\Helper\AliasHelper;
use Instance\Factory\InstanceManagerFactoryTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AliasHelperFactory implements FactoryInterface
{
    use AliasManagerFactoryTrait, InstanceManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $helperPluginManager
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $helperPluginManager)
    {
        $serviceLocator  = $helperPluginManager->getServiceLocator();
        $aliasManager    = $this->getAliasManager($serviceLocator);
        $instanceManager = $this->getInstanceManager($serviceLocator);
        return new AliasHelper($aliasManager, $instanceManager);
    }
}
