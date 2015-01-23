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
namespace Instance\Strategy;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

class StrategyPluginManager extends AbstractPluginManager
{
    /**
     * {@inheritDoc}
     */
    protected $autoAddInvokableClass = false;

    /**
     * {@inheritDoc}
     */
    protected $factories = [
        'Instance\Strategy\DomainStrategy' => 'Instance\Factory\DomainStrategyFactory',
        'Instance\Strategy\CookieStrategy' => 'Instance\Factory\CookieStrategyFactory'
    ];

    /**
     * {@inheritDoc}
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof StrategyInterface) {
            throw new Exception\RuntimeException(sprintf(
                'Expected instance of StrategyInterface but got %s.',
                is_object($plugin) ? get_class($plugin) : gettype($plugin)
            ));
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function canonicalizeName($name)
    {
        return $name;
    }
}
