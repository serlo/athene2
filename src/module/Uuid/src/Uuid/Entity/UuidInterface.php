<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Uuid\Entity;

interface UuidInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return bool
     */
    public function getTrashed();

    /**
     * Alias for getTrashed()
     *
     * @return bool
     */
    public function isTrashed();

    /**
     * @param bool $trashed
     * @return void
     */
    public function setTrashed($trashed);

    /**
     * @return string
     */
    public function __toString();
}
