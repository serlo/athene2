<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Metadata\Entity;

use Uuid\Entity\UuidInterface;

interface MetadataInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getValue();

    /**
     * @return MetadataKeyInterface
     */
    public function getKey();

    /**
     * @return UuidInterface
     */
    public function getObject();

    /**
     * @param UuidInterface $object
     * @return self
     */
    public function setObject(UuidInterface $object);

    /**
     * @param MetadataKeyInterface $key
     * @return self
     */
    public function setKey(MetadataKeyInterface $key);

    /**
     * @param unknown $value
     * @return self
     */
    public function setValue($value);
}
