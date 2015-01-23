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
