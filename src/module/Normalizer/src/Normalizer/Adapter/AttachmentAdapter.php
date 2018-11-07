<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Normalizer\Adapter;

use Attachment\Entity\ContainerInterface;
use Normalizer\Exception\RuntimeException;

class AttachmentAdapter extends AbstractAdapter
{
    /**
     * @return ContainerInterface
     */
    public function getObject()
    {
        return $this->object;
    }

    public function isValid($object)
    {
        return $object instanceof ContainerInterface;
    }

    protected function getContent()
    {
        return $this->getFile()->getLocation();
    }

    protected function getCreationDate()
    {
        return $this->getFile()->getDateTime();
    }

    protected function getFile()
    {
        $file = $this->getObject()->getFiles()->current();
        if (!is_object($file)) {
            throw new RuntimeException('No files have been attached');
        }
        return $file;
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
        return $this->getFile()->getLocation();
    }

    protected function getRouteName()
    {
        return 'attachment/info';
    }

    protected function getRouteParams()
    {
        return [
            'id' => $this->getObject()->getId(),
        ];
    }

    protected function getTitle()
    {
        return $this->getFile()->getFilename();
    }

    protected function getType()
    {
        return $this->getObject()->getType();
    }

    protected function isTrashed()
    {
        return false;
    }
}
