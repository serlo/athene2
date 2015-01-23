<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event\Entity;

interface EventInterface
{
    /**
     * Returns the event's id.
     *
     * @return int
     */
    public function getId();

    /**
     * Returns the event's name.
     *
     * @return string
     */
    public function getName();

    /**
     * Returns the event's description.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Sets the event's name.
     *
     * @param string $name
     * @return self
     */
    public function setName($name);

    /**
     * Sets the event's description.
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description);
}
