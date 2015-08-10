<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Entity;

use Uuid\Entity\UuidInterface;

interface InternalInterface extends TypeInterface
{
    /**
     * @return UuidInterface
     */
    public function getReference();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     * @return self
     */
    public function setTitle($title);

    /**
     * @param UuidInterface $uuid
     * @return self
     */
    public function setReference(UuidInterface $uuid);
}
