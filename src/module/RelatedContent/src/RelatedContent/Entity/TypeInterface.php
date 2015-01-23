<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
