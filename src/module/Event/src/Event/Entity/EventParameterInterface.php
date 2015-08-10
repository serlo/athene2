<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Event\Entity;

use Instance\Entity\InstanceProviderInterface;
use Uuid\Entity\UuidInterface;

interface EventParameterInterface extends InstanceProviderInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return EventLogInterface
     */
    public function getLog();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return UuidInterface
     */
    public function getValue();

    /**
     * @param EventLogInterface $log
     * @return self
     */
    public function setLog(EventLogInterface $log);

    /**
     * @param EventParameterNameInterface $name
     * @return self
     */
    public function setName(EventParameterNameInterface $name);

    /**
     * @param UuidInterface|string $value
     * @return self
     */
    public function setValue($value);
}
