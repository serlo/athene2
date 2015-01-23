<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification;

trait SubscriptionManagerAwareTrait
{

    /**
     * @var SubscriptionManagerInterface
     */
    protected $subscriptionManager;

    /**
     * @return SubscriptionManagerInterface $subscriptionManager
     */
    public function getSubscriptionManager()
    {
        return $this->subscriptionManager;
    }

    /**
     * @param SubscriptionManagerInterface $subscriptionManager
     * @return self
     */
    public function setSubscriptionManager(SubscriptionManagerInterface $subscriptionManager)
    {
        $this->subscriptionManager = $subscriptionManager;

        return $this;
    }
}
