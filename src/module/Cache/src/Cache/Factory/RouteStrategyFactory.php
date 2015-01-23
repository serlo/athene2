<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Jakob Pfab (jakob.pfab@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Cache\Factory;

use Cache\Strategy\RouteStrategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RouteStrategyFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var $options \StrokerCache\Options\ModuleOptions */
        $options = $serviceLocator->getServiceLocator()->get('StrokerCache\Options\ModuleOptions');

        $strategyOptions = array();
        $strategies      = $options->getStrategies();
        $requestedName   = 'Cache\Strategy\RouteStrategy';
        if (isset($strategies['enabled'][$requestedName])) {
            $strategyOptions = $strategies['enabled'][$requestedName];
        }

        $strategy = new RouteStrategy($strategyOptions);

        return $strategy;
    }
}
