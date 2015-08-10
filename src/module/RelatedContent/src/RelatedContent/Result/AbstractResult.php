<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Result;

use RelatedContent\Entity\TypeInterface;

abstract class AbstractResult implements ResultInterface
{

    protected $object;

    public function getObject()
    {
        return $this->object;
    }

    public function setObject(TypeInterface $object)
    {
        $this->object = $object;
        return $this;
    }

    public function getId()
    {
        return $this->getObject()
            ->getId();
    }
}
