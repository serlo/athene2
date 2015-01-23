<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license	LGPL-3.0
 * @license	http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
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
