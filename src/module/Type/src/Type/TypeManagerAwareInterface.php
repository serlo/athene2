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

interface TypeManagerAwareInterface
{

    /**
     * Gets the type manager
     *
     * @return TypeManagerInterface $typeManager
     */
    public function getTypeManager();

    /**
     * Sets the type manager
     *
     * @param TypeManagerInterface $typeManager
     * @return self
     */
    public function setTypeManager(TypeManagerInterface $typeManager);
}
