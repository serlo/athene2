<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Normalizer\Adapter;

use Page\Entity\PageRepositoryInterface;

class PageRepositoryAdapter extends AbstractAdapter
{

    /**
     * @return PageRepositoryInterface
     */
    public function getObject()
    {
        return $this->object;
    }

    public function isValid($object)
    {
        return $object instanceof PageRepositoryInterface;
    }

    protected function getContent()
    {
        $revision = $this->getRevision();
        if ($revision) {
            return $revision->getContent();
        }
        return '';
    }

    protected function getCreationDate()
    {
        $revision = $this->getRevision();
        if ($revision) {
            return $revision->getDate();
        }
        return new \DateTime;
    }

    protected function getId()
    {
        return $this->getObject()->getId();
    }

    protected function getKeywords()
    {
        return explode(' ', $this->getTitle());
    }

    protected function getPreview()
    {
        $revision = $this->getRevision();
        if ($revision) {
            return $revision->getContent();
        }
        return '';
    }

    protected function getRevision()
    {
        $revision = $this->getObject()->getCurrentRevision();
        if (!$revision) {
            $revision = $this->getObject()->getRevisions()->current();
        }
        return $revision;
    }

    protected function getRouteName()
    {
        return 'page/view';
    }

    protected function getRouteParams()
    {
        return [
            'page' => $this->getObject()->getId(),
        ];
    }

    protected function getTitle()
    {
        $revision = $this->getRevision();
        if ($revision) {
            return $revision->getTitle();
        }
        return '';
    }

    protected function getType()
    {
        return 'Page';
    }

    protected function isTrashed()
    {
        return $this->getObject()->isTrashed();
    }
}
