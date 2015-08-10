<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Entity;

interface TypeInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return RelatedContentInterface
     */
    public function getHolder();

    /**
     * @return RelationInterface
     */
    public function getContainer();

    /**
     * @param HolderInterface $container
     * @return self
     */
    public function setHolder(HolderInterface $holder);
}
