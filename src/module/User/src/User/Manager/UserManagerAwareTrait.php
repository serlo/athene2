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
