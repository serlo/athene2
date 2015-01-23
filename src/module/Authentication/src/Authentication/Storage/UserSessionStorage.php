<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Authentication\Storage;

use ClassResolver\ClassResolverAwareTrait;
use ClassResolver\ClassResolverInterface;
use Common\Traits\ObjectManagerAwareTrait;
use Doctrine\Common\Persistence\ObjectManager;
use User\Exception\UserNotFoundException;
use Zend\Authentication\Storage\Session;

class UserSessionStorage extends Session
{
    use ObjectManagerAwareTrait, ClassResolverAwareTrait;

    protected $rememberTime;

    public function __construct(
        ClassResolverInterface $classResolver,
        ObjectManager $objectManager,
        $rememberTime = 2419200
    ) {
        parent::__construct('authentication');
        $this->classResolver = $classResolver;
        $this->objectManager = $objectManager;
        $this->rememberTime  = $rememberTime;
    }

    public function setRememberMe($rememberMe = false)
    {
        if ($rememberMe) {
            $this->session->getManager()->rememberMe($this->rememberTime);
        }
    }

    public function write($contents)
    {
        $id = $contents->getId();
        parent::write($id);
    }

    public function read()
    {
        $className = $this->getClassResolver()->resolveClassName('User\Entity\UserInterface');
        $id        = parent::read();
        $user      = $this->getObjectManager()->find($className, $id);
        if (!$user) {
            throw new UserNotFoundException(sprintf('User %s not found', $id));
        }

        return $user;
    }

    public function clear()
    {
        $this->session->getManager()->forgetMe();
        parent::clear();
    }
}
