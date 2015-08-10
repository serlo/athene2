<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
