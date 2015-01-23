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

abstract class AbstractType implements TypeInterface
{
    protected $id;

    public function getId()
    {
        return $this->id->getId();
    }

    public function getHolder()
    {
        return $this->id;
    }

    public function setHolder(HolderInterface $holder)
    {
        $this->id = $holder;
    }

    public function getContainer()
    {
        return $this->getContainer();
    }
}
