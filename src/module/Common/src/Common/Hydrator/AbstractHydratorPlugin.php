<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Common\Hydrator;

abstract class AbstractHydratorPlugin implements HydratorPluginInterface
{
    /**
     * Extracts (key, value) pairs from the object for merging with the overall extract result.
     * Most plugins don't need custom extraction but rather custom hydration.
     * This method always returns an empty set.
     *
     * @param object $object
     * @return array
     */
    public function extract($object)
    {
        return [];
    }
}
