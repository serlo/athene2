<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Flag\Entity;

use Instance\Entity\InstanceAwareInterface;
use Type\Entity\TypeAwareInterface;
use User\Entity\UserInterface;
use Uuid\Entity\UuidInterface;

interface FlagInterface extends TypeAwareInterface, InstanceAwareInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @return UuidInterface
     */
    public function getObject();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return UserInterface
     */
    public function getReporter();

    /**
     * @return \DateTime
     */
    public function getTimestamp();

    /**
     * @param UuidInterface $uuid
     * @return self
     */
    public function setObject(UuidInterface $uuid);

    /**
     * @param string $content
     * @return self
     */
    public function setContent($content);

    /**
     * @param UserInterface $user
     * @return self
     */
    public function setReporter(UserInterface $user);
}
