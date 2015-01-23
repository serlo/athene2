<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
