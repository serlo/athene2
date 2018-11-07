<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Ads\Factory;

use Ads\View\Helper\Banner;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BannerHelperFactory implements FactoryInterface
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
        $request               = $serviceLocator->get('Request');
        $viewHelper      = new Banner($request);
        $viewHelper->setAdsManager($adsManager);
        $viewHelper->setInstanceManager($instanceManager);

        return $viewHelper;
    }
}
