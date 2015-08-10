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

use Search\Entity\DocumentInterface;
use Search\Exception\InvalidArgumentException;

interface ProviderInterface
{
    /**
     * @return DocumentInterface[]
     */
    public function provide();

    /**
     * Converts an object into a Document
     *
     * @param object $object
     * @return DocumentInterface
     * @throws InvalidArgumentException
     */
    public function toDocument($object);

    /**
     * Returns the object's ID
     *
     * @param object $object
     * @return int
     */
    public function getId($object);
}
