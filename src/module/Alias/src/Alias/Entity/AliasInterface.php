<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Alias\Entity;

use DateTime;
use Instance\Entity\InstanceAwareInterface;
use Uuid\Entity\UuidInterface;

interface AliasInterface extends InstanceAwareInterface
{

    /**
     * Returns the ID
     *
     * @return int
     */
    public function getId();

    /**
     * Returns the source
     *
     * @return string
     */
    public function getSource();

    /**
     * Returns the alias
     *
     * @return string
     */
    public function getAlias();

    /**
     * Gets the object
     *
     * @return UuidInterface
     */
    public function getObject();

    /**
     * Sets the source
     *
     * @param string $source
     * @return void
     */
    public function setSource($source);

    /**
     * Sets the alias
     *
     * @param string $alias
     * @return void
     */
    public function setAlias($alias);

    /**
     * Sets the object
     *
     * @param UuidInterface $uuid
     * @return void
     */
    public function setObject(UuidInterface $uuid);

    /**
     * @return DateTime
     */
    public function getTimestamp();

    /**
     * @param DateTime $timestamp
     * @return void
     */
    public function setTimestamp(DateTime $timestamp);
}
