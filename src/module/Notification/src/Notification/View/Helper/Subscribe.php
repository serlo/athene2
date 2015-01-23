<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */

namespace Notification\View\Helper;


use Notification\SubscriptionManagerInterface;
use User\Manager\UserManagerInterface;
use Uuid\Entity\UuidInterface;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\Partial;

class Subscribe extends AbstractHelper
{
    /**
     * @var SubscriptionManagerInterface
     */
    protected $subscriptionManager;

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @var bool
     */
    protected $isSubscribed = false;

    /**
     * @var bool
     */
    protected $emailsActive;

    /**
     * @var UuidInterface
     */
    protected $object;

    /**
     * @param UserManagerInterface         $userManager
     * @param SubscriptionManagerInterface $subscriptionManager
     */
    public function __construct(UserManagerInterface $userManager, SubscriptionManagerInterface $subscriptionManager)
    {
        $this->userManager         = $userManager;
        $this->subscriptionManager = $subscriptionManager;
    }

    /**
     * @param UuidInterface $object
     * @return $this
     */
    public function __invoke(UuidInterface $object)
    {
        $user               = $this->userManager->getUserFromAuthenticator();
        $this->object       = $object;
        $this->emailsActive = false;
        $this->isSubscribed = false;

        if (!is_object($user)) {
            return $this;
        }

        $this->isSubscribed = $this->subscriptionManager->isUserSubscribed($user, $object);

        if (!$this->isSubscribed) {
            return $this;
        }

        $subscription       = $this->subscriptionManager->findSubscription($user, $object);
        $this->emailsActive = $subscription->getNotifyMailman();

        return $this;
    }

    /**
     * @return string
     */
    public function button()
    {
        /* @var Partial */
        $partial  = $this->getView()->plugin('partial');
        $template = $this->isSubscribed ? 'opt-out' : 'opt-in';
        return $partial(
            'notification/subscription/' . $template . '/button',
            ['object' => $this->object->getId(), 'emailsActive' => $this->emailsActive]
        );
    }

    /**
     * @return string
     */
    public function menuItem()
    {
        /* @var Partial */
        $partial  = $this->getView()->plugin('partial');
        $template = $this->isSubscribed ? 'opt-out' : 'opt-in';
        return $partial(
            'notification/subscription/' . $template . '/menu-item',
            ['object' => $this->object->getId(), 'emailsActive' => $this->emailsActive]
        );
    }

    /**
     * @return string
     */
    public function subMenuItem()
    {
        /* @var Partial */
        $partial  = $this->getView()->plugin('partial');
        $template = $this->isSubscribed ? 'opt-out' : 'opt-in';
        return $partial(
            'notification/subscription/' . $template . '/sub-menu-item',
            ['object' => $this->object->getId(), 'emailsActive' => $this->emailsActive]
        );
    }
}
