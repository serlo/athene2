<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification\Listener;

use Common\Listener\AbstractSharedListenerAggregate;
use Notification\SubscriptionManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
use Notification\SubscriptionManagerAwareTrait;

abstract class AbstractListener extends AbstractSharedListenerAggregate implements SharedListenerAggregateInterface
{
    use SubscriptionManagerAwareTrait;

    public function __construct(SubscriptionManagerInterface $subscriptionManager)
    {
        if (!class_exists($this->getMonitoredClass())) {
            throw new \RuntimeException(sprintf(
                'The class you are trying to attach to does not exist: %s',
                $this->getMonitoredClass()
            ));
        }
        $this->subscriptionManager = $subscriptionManager;
    }

    public function subscribe($user, $object, $notifyMailman)
    {
        $this->getSubscriptionManager()->subscribe($user, $object, $notifyMailman);
    }
}
