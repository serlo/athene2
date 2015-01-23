<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license	LGPL-3.0
 * @license	http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace User\Hydrator;

use User\Entity\UserInterface;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\Hydrator\HydratorInterface;

class UserHydrator implements HydratorInterface
{
    public function extract($object)
    {
        $object = $this->isValid($object);
        
        return [
            'id' => $object->getId(),
            'email' => $object->getEmail(),
            'username' => $object->getUsername(),
            'password' => $object->getPassword()
        ];
    }

    public function hydrate(array $data, $object)
    {
        $object = $this->isValid($object);
    	$data = ArrayUtils::merge($this->extract($object), $data);

    	$object->setUsername($data['username']);
    	$object->setPassword($data['password']);
        $object->setEmail($data['email']);

        return $object;
    }

    /**
     *
     * @param UserInterface $object            
     * @return UserInterface
     */
    protected function isValid(UserInterface $object)
    {
        return $object;
    }
}
