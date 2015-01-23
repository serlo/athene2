<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
