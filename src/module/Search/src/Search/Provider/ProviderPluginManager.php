<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Search\Provider;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

class ProviderPluginManager extends AbstractPluginManager
{
    /**
     * {@inheritDoc}
     */
    protected $autoAddInvokableClass = false;

    /**
     * {@inheritDoc}
     */
    protected $factories = [
        'Search\Provider\EntityProvider'   => 'Search\Factory\EntityProviderFactory',
        'Search\Provider\TaxonomyProvider' => 'Search\Factory\TaxonomyProviderFactory'
    ];

    /**
     * {@inheritDoc}
     */
    public function validatePlugin($plugin)
    {
        if (!$plugin instanceof ProviderInterface) {
            throw new Exception\RuntimeException(sprintf(
                'Expected instance of AdapterInterface but got %s.',
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
