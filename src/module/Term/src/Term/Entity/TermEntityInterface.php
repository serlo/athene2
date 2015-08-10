<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Term\Entity;

use Instance\Entity\InstanceAwareInterface;

interface TermEntityInterface extends InstanceAwareInterface
{

    /**
     * @return int $id
     */
    public function getId();

    /**
     * @return string $name
     */
    public function getName();

    /**
     * @param string $name
     * @return void
     */
    public function setName($name);
}
