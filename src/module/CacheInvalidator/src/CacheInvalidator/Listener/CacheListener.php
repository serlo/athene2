<?php
namespace CacheInvalidator\Listener;

use CacheInvalidator\Invalidator\InvalidatorManager;
use CacheInvalidator\Options\CacheOptions;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CacheListener Implements SharedListenerAggregateInterface
{
    /**
     * @var CacheOptions
     */
    protected $cacheOptions;

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @var InvalidatorManager
     */
    protected $strategyManager;

    /**
     * @param CacheOptions       $cacheOptions
     * @param InvalidatorManager $strategyManager
     */
    public function __construct(CacheOptions $cacheOptions, InvalidatorManager $strategyManager)
    {
        $this->cacheOptions    = $cacheOptions;
        $this->strategyManager = $strategyManager;
    }

    /**
     * @param SharedEventManagerInterface $events
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $classes = $this->cacheOptions->getListens();
        foreach ($classes as $class => $options) {
            foreach ($options as $event => $invalidators) {
                $strategyManager = $this->strategyManager;
                $events->attach(
                    $class,
                    $event,
                    function (Event $e) use ($class, $event, $invalidators, $strategyManager) {
                        foreach ($invalidators as $invalidator) {
                            $invalidator = $strategyManager->get($invalidator);
                            $invalidator->invalidate($e, $class, $event);
                        }
                    }
                );
            }
        }
    }

    /**
     * Detach all previously attached listeners
     *
     * @param SharedEventManagerInterface $events
     */
    public function detachShared(SharedEventManagerInterface $events)
    {
        // TODO: Implement detachShared() method.
    }
}
