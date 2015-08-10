<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Type;

use Doctrine\Common\Collections\Collection;

interface TypeManagerInterface
{

    /**
     * Gets a type
     *
     * @param id $id
     * @return Entity\TypeInterface
     */
    public function getType($id);

    /**
     * Gets a type by its name
     *
     * @param string $name
     * @return Entity\TypeInterface
     */
    public function findTypeByName($name);

    /**
     * Finds multiple types by their names
     *
     * @param array $names
     * @return Entity\TypeInterface[]
     */
    public function findTypesByNames(array $names);

    /**
     * Gets a type by its name
     *
     * @return Collection|Entity\TypeInterface[]
     */
    public function findAllTypes();
}
