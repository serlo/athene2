<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */

namespace CacheInvalidator\Invalidator;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

class InvalidatorManager extends AbstractPluginManager
{
    /**
     * Validate the plugin
     * Checks that the filter loaded is either a valid callback or an instance
     * of FilterInterface.
     *
     * @param  mixed $plugin
     * @return void
     * @throws Exception\RuntimeException if invalid
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof InvalidatorInterface) {
            throw new Exception\RuntimeException(sprintf(
                'Expected instance of InvalidationStrategyInterface but got %s',
                is_object($plugin) ? get_class($plugin) : gettype($plugin)
            ));
        }
    }
}
