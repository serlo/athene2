<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
