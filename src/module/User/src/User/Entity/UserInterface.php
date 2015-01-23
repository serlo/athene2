<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace User\Entity;

use Authorization\Entity\RoleInterface;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Uuid\Entity\UuidInterface;
use ZfcRbac\Identity\IdentityInterface;

interface UserInterface extends UuidInterface, IdentityInterface
{

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @return string
     */
    public function getLogins();

    /**
     * @return DateTime
     */
    public function getLastLogin();

    /**
     * @return DateTime
     */
    public function getDate();

    /**
     * @return Collection RoleInterface[]
     */
    public function getRoles();

    /**
     * @return string
     */
    public function getToken();

    /**
     * @return self
     */
    public function generateToken();

    /**
     * @param string $email
     * @return self
     */
    public function setEmail($email);

    /**
     * @param string $username
     * @return self
     */
    public function setUsername($username);

    /**
     * @param string $password
     * @return self
     */
    public function setPassword($password);

    /**
     * @param DateTime $lastLogin
     * @return self
     */
    public function setLastLogin(DateTime $lastLogin);

    /**
     * @param DateTime $date
     * @return self
     */
    public function setDate(DateTime $date);

    /**
     * @param RoleInterface $role
     * @return self
     */
    public function addRole(RoleInterface $role);

    /**
     * @param RoleInterface $role
     * @return self
     */
    public function removeRole(RoleInterface $role);

    /**
     * @param RoleInterface $role
     */
    public function hasRole(RoleInterface $role);
}
