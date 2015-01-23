<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Ads\Factory;


use Ads\View\Helper\Horizon;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class HorizonHelperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator  = $serviceLocator->getServiceLocator();
        $instanceManager = $serviceLocator->get('Instance\Manager\InstanceManager');
        $adsManager      = $serviceLocator->get('Ads\Manager\AdsManager');
        $viewHelper      = new Horizon();
        $viewHelper->setAdsManager($adsManager);
        $viewHelper->setInstanceManager($instanceManager);

        return $viewHelper;
    }
}
