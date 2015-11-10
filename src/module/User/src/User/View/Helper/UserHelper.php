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
use Firebase\JWT\JWT;

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

    public function getAuthenticatedUserName(){
        $user = $this->userManager->getUserFromAuthenticator();
        return $user ? $user->getUsername() : '';
    }

    public function isUserLoggedIn(){
        return ($this->getAuthenticatedUserID() != '');
    }

    public function createJWSScrollback(){
        $payload = array(
            "iss" => "http://serlo.org",
            "sub" => "".$this->getAuthenticatedUserEMail()."",
            "aud" => "scrollback.io",
            "iat" => time(),
            "exp" => time()+60
        );
        $key = 'dummy_key';
        $head  = array(
            "alg" => "HS256",
            "typ" => "JWS"
        );

        return JWT::encode($payload, $key, 'HS256' , null, $head);
    }

    public function decodeToken($token){
        return JWT::decode($token, "dummy_key", array('HS256'));
    }

    public function getAuthenticatedUserEMail(){
        $user = $this->userManager->getUserFromAuthenticator();
        return $user ? $user->getEmail() : '';
    }
}
