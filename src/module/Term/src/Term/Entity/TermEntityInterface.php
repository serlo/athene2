<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
