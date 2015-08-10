<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace User\Manager;

interface UserManagerAwareInterface
{
    /**
     * @return UserManagerInterface
     */
    public function getUserManager();

    /**
     * @param UserManagerInterface $userManager
     * @return self
     */
    public function setUserManager(UserManagerInterface $userManager);
}
