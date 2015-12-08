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
use Instance\Manager\InstanceManagerAwareTrait;
use Zend\View\Helper\AbstractHelper;
use Firebase\JWT\JWT;

include_once 'secrets.php';

class UserHelper extends AbstractHelper
{

    use InstanceManagerAwareTrait;

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
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
    public function getAuthenticatedUserID()
    {
        $user = $this->userManager->getUserFromAuthenticator();
        return $user ? $user->getId() : '';
    }

    public function getAuthenticatedUserName()
    {
        $user = $this->userManager->getUserFromAuthenticator();
        return $user ? $user->getUsername() : '';
    }

    public function isUserLoggedIn()
    {
        return ($this->getAuthenticatedUserID() != '');
    }

    public function createJWSScrollback()
    {
        //$this->getInstanceManager()->getInstance()->getSubdomain();
        $payload = array(
            'iss' => 'https://de.serlo.org',   //TODO: getSubdomain()
            'sub' => '' . $this->getAuthenticatedUserEmail() . '',
            'aud' => 'scrollback.io',
            'iat' => time(),
            'exp' => time() + 60
        );
        $key = apache_getenv('ChatKey');
        $head = array(
            'alg' => 'HS256',
            'typ' => 'JWS'
        );

        return JWT::encode($payload, $key, 'HS256' , null, $head);
    }

    public function getAuthenticatedUserEmail()
    {
        $user = $this->userManager->getUserFromAuthenticator();
        return $user ? $user->getEmail() : '';
    }
}
