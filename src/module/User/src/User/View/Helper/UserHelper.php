<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace User\View\Helper;

use User\Manager\UserManagerInterface;
use Zend\View\Helper\AbstractHelper;

class UserHelper extends AbstractHelper
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager) {
        $this->userManager = $userManager;
    }

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @return \User\Entity\UserInterface
     */
    public function getAuthenticatedUserID() {
        $user = $this->userManager->getUserFromAuthenticator();
        return $user ? $user->getId() : '';
    }
}
