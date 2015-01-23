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

use Blog\Entity\PostInterface;

class PostAdapter extends AbstractAdapter
{

    /**
     * @return PostInterface
     */
    public function getObject()
    {
        return $this->object;
    }

    public function isValid($object)
    {
        return $object instanceof PostInterface;
    }

    protected function getContent()
    {
        return $this->getObject()->getContent();
    }

    protected function getKeywords()
    {
        return [];
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
        return 'blog/post/view';
    }

    protected function getRouteParams()
    {
        return [
            'post' => $this->getObject()->getId()
        ];
    }

    protected function getCreationDate()
    {
        return $this->getObject()->getTimestamp();
    }

    protected function getTitle()
    {
        return $this->getObject()->getTitle();
    }

    protected function getType()
    {
        return 'blogPost';
    }
}
