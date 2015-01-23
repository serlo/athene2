<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Result;

class Result implements ResultInterface
{

    protected $result;

    /**
     * @return field_type $result
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param field_type $result
     * @return self
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }
}
