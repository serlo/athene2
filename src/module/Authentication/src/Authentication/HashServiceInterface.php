<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Authentication;

interface HashServiceInterface
{
    public function findSalt($password);

    /**
     * @param string $password
     * @param bool   $salt
     * @return string
     */
    public function hashPassword($password, $salt = false);
}
