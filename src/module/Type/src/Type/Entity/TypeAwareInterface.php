<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
