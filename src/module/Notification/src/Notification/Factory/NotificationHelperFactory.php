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
namespace Notification\Factory;

use Notification\View\Helper\Notification;
use User\Factory\UserManagerFactoryTrait;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class NotificationHelperFactory implements FactoryInterface
{
    use UserManagerFactoryTrait;

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var AbstractPluginManager $serviceLocator */
        $serviceManager      = $serviceLocator->getServiceLocator();
        $userManager         = $this->getUserManager($serviceManager);
        $notificationManager = $serviceManager->get('Notification\NotificationManager');
        $storage             = $serviceManager->get('Notification\Storage\Storage');
        $renderer            = $serviceManager->get('ZfcTwig\View\TwigRenderer');

        return new Notification($notificationManager, $storage, $renderer, $userManager);
    }

}
