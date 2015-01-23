<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Type\Entity;

interface TypeAwareInterface
{

    /**
     * Gets the type
     *
     * @return TypeInterface
     */
    public function getType();

    /**
     * Sets the type
     *
     * @param TypeInterface $type
     * @return self
     */
    public function setType(TypeInterface $type);
}
