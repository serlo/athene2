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
namespace CacheInvalidator\Invalidator;

use Zend\Cache\Storage\FlushableInterface;
use Zend\EventManager\Event;

class NavigationStorageInvalidator implements InvalidatorInterface
{
    /**
     * @var FlushableInterface
     */
    protected $storage;

    /**
     * @param FlushableInterface $storage
     */
    public function __construct(FlushableInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param Event  $e
     * @param string $class
     * @param string $event
     * @return void
     */
    public function invalidate(Event $e, $class, $event)
    {
        if ($this->storage instanceof FlushableInterface) {
            $this->storage->flush();
        }
    }
}
