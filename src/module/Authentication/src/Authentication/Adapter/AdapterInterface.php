<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Authentication\Adapter;

use Zend\Authentication\Adapter\AdapterInterface as AI;

interface AdapterInterface extends AI
{

    /**
     * 
     * @param string $email
     * @return self
     */
    public function setIdentity($email);

    /**
     * 
     * @param string $password
     * @return self
     */
    public function setCredential($password);
}
