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

interface HydratorPluginInterface
{
    /**
     * Extracts (key, value) pairs from the object for merging with the overall extract result.
     *
     * @param object $object
     * @return array
     */
    public function extract($object);

    /**
     * (Partially) hydrates the object and removes the affected (key, value) pairs from the return set.
     *
     * @param object $object
     * @param array  $data
     * @return array
     */
    public function hydrate($object, array $data);
}
