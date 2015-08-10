<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Options;

use Zend\Stdlib\AbstractOptions;

class RedirectOptions extends AbstractOptions implements ComponentOptionsInterface
{
    /**
     * @var string
     */
    protected $toType;

    /**
     * @param string $toType
     * @return void
     */
    public function setToType($toType)
    {
        $this->toType = $toType;
    }

    /**
     * @return string
     */
    public function getToType()
    {
        return $this->toType;
    }


    /**
     * @param string $key
     * @return bool
     */
    public function isValid($key)
    {
        return $key === 'redirect';
    }
}
