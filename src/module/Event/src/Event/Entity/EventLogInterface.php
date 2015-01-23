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

use Datetime;
use Instance\Entity\InstanceAwareInterface;
use User\Entity\UserInterface;
use Uuid\Entity\UuidInterface;

interface EventLogInterface extends InstanceAwareInterface
{

    /**
     * @param EventParameterInterface $parameter
     * @return self
     */
    public function addParameter(EventParameterInterface $parameter);

    /**
     * Gets the actor
     *
     * @return UserInterface
     */
    public function getActor();

    /**
     * Gets the event
     *
     * @return EventInterface
     */
    public function getEvent();

    /**
     * Returns the id
     *
     * @return int
     */
    public function getId();

    /**
     * Returns the name
     *
     * @return string
     */
    public function getName();

    /**
     * Gets the associated object (uuid)
     *
     * @return UuidInterface
     */
    public function getObject();

    /**
     * @return UuidInterface
     */
    public function getParameter($name);

    /**
     * @return EventParameterInterface[]
     */
    public function getParameters();

    /**
     * @return Datetime
     */
    public function getTimestamp();

    /**
     * Sets the actor.
     *
     * @param UserInterface $actor
     * @return self
     */
    public function setActor(UserInterface $actor);

    /**
     * Sets the event.
     *
     * @param EventInterface $event
     * @return self
     */
    public function setEvent(EventInterface $event);

    /**
     * Sets the associated object (uuid)
     *
     * @param UuidInterface $uuid
     * @return self
     */
    public function setObject(UuidInterface $uuid);
}
