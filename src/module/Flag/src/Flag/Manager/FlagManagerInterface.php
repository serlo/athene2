<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Flag\Manager;

use Common\ObjectManager\Flushable;
use Doctrine\Common\Collections\Collection;
use Flag\Entity\FlagInterface;
use Type\Entity\TypeInterface;

interface FlagManagerInterface extends Flushable
{
    /**
     * @param int $id
     * @return FlagInterface
     */
    public function getFlag($id);

    /**
     * @return FlagInterface[]|Collection
     */
    public function findAllFlags();

    /**
     * @return TypeInterface[]
     */
    public function findAllTypes();

    /**
     * @param int $id
     * @return self
     */
    public function removeFlag($id);

    /**
     * @param int    $type
     * @param string $content
     * @param int    $uuid
     * @return FlagInterface
     */
    public function addFlag($type, $content, $uuid);
}
