<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Normalizer\Adapter;

use User\Entity\UserInterface;

class UserAdapter extends AbstractAdapter
{

    /**
     * @return UserInterface
     */
    public function getObject()
    {
        return $this->object;
    }

    public function isValid($object)
    {
        return $object instanceof UserInterface;
    }

    protected function getContent()
    {
        return $this->getObject()->getUsername();
    }

    protected function getId()
    {
        return $this->getObject()->getId();
    }

    protected function getKeywords()
    {
        return [];
    }

    protected function getPreview()
    {
        return $this->getObject()->getUsername();
    }

    protected function getRouteName()
    {
        return 'user/profile';
    }

    protected function getRouteParams()
    {
        return ['id' => $this->getObject()->getId()];
    }

    protected function getCreationDate()
    {
        return $this->getObject()->getDate();
    }

    protected function getTitle()
    {
        return $this->getObject()->getUsername();
    }

    protected function getType()
    {
        return 'user';
    }
    protected function isTrashed()
    {
        return $this->getObject()->isTrashed();
    }
}
