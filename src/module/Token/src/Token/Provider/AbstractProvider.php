<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Token\Provider;

abstract class AbstractProvider implements ProviderInterface
{

    protected $object;

    /**
     * @return mixed $reference
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param mixed $reference
     * @return self
     */
    public function setObject($object)
    {
        $this->validObject($object);
        $this->object = $object;
        return $this;
    }

    abstract protected function validObject($object);
}
