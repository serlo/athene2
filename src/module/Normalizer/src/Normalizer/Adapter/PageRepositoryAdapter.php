<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
            'page' => $this->getObject()->getId()
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
}
