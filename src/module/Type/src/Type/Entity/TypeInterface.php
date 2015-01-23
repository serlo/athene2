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

interface TypeInterface
{

    /**
     * @return string
     */
    public function __toString();

    /**
     * Returns the ID
     *
     * @return int
     */
    public function getId();

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName();

    /**
     * Sets the name
     *
     * @param string $name
     * @return self
     */
    public function setName($name);
}
