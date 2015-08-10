<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Discussion\Factory;

use Discussion\View\Helper\Discussion;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DiscussionHelperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator        = $serviceLocator->getServiceLocator();
        $discussionManager     = $serviceLocator->get('Discussion\DiscussionManager');
        $userManager           = $serviceLocator->get('User\Manager\UserManager');
        $instanceManager       = $serviceLocator->get('Instance\Manager\InstanceManager');
        $sharedTaxonomyManager = $serviceLocator->get('Taxonomy\Manager\TaxonomyManager');
        $termForm              = $serviceLocator->get('Taxonomy\Form\TermForm');
        $discussionForm        = $serviceLocator->get('Discussion\Form\DiscussionForm');
        $commentForm           = $serviceLocator->get('Discussion\Form\CommentForm');
        $renderer              = $serviceLocator->get('ZfcTwig\View\TwigRenderer');
        $request               = $serviceLocator->get('Request');
        $plugin                = new Discussion($termForm, $commentForm, $discussionForm, $renderer, $request);

        $plugin->setDiscussionManager($discussionManager);
        $plugin->setUserManager($userManager);
        $plugin->setInstanceManager($instanceManager);
        $plugin->setTaxonomyManager($sharedTaxonomyManager);

        return $plugin;
    }
}
