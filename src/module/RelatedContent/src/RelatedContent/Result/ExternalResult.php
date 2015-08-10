<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace RelatedContent\Result;

use RelatedContent\Entity\ExternalInterface;
use RelatedContent\Entity\TypeInterface;
use RelatedContent\Exception;

class ExternalResult extends AbstractResult
{

    /**
     * @return ExternalInterface
     */
    public function getObject()
    {
        return parent::getObject();
    }

    public function setObject(TypeInterface $object)
    {
        if (!$object instanceof ExternalInterface) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Expected ExternalInterface but got `%s`',
                get_class($object)
            ));
        }
        return parent::setObject($object);
    }

    public function getType()
    {
        return 'external';
    }

    /*
     * (non-PHPdoc) @see \Related\Result\ResultInterface::getTitle()
     */
    public function getTitle()
    {
        return $this->getObject()->getTitle();
    }

    /*
     * (non-PHPdoc) @see \Related\Result\ResultInterface::getUrl()
     */
    public function getUrl()
    {
        return $this->getObject()->getUrl();
    }
}
