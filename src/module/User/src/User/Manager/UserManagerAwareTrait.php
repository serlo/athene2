<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace User\Manager;

trait UserManagerAwareTrait
{

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @return \User\Manager\UserManagerInterface
     *         $userManager
     */
    public function getUserManager()
    {
        return $this->userManager;
    }

    /**
     * @param \User\Manager\UserManagerInterface $userManager
     * @return self
     */
    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
        return $this;
    }
}
