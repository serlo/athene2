<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @author      Jakob Pfab
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Normalizer\Adapter;

use Page\Entity\PageRevisionInterface;

class PageRevisionAdapter extends AbstractAdapter
{

    /**
     * @return PageRevisionInterface
     */
    public function getObject()
    {
        return $this->object;
    }

    public function isValid($object)
    {
        return $object instanceof PageRevisionInterface;
    }

    protected function getKeywords()
    {
        return explode(' ', $this->getTitle());
    }

    protected function getContent()
    {
        return $this->getObject()->getContent();
    }

    protected function getId()
    {
        return $this->getObject()->getId();
    }

    protected function getPreview()
    {
        return $this->getObject()->getContent();
    }

    protected function getRouteName()
    {
        return 'page/revision/view';
    }

    protected function getRouteParams()
    {
        return [
            'revision' => $this->getObject()->getId(),
        ];
    }

    protected function getCreationDate()
    {
        return $this->getObject()->getDate();
    }

    protected function getTitle()
    {
        return $this->getObject()->getTitle();
    }

    protected function getType()
    {
        return 'Page revision';
    }

    protected function isTrashed()
    {
        return $this->getObject()->isTrashed();
    }
}
