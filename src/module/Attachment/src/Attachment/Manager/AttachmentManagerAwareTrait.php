<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Attachment\Manager;

trait AttachmentManagerAwareTrait
{

    /**
     * @var AttachmentManagerInterface
     */
    protected $uploadManager;

    /**
     * @return AttachmentManagerInterface $uploadManager
     */
    public function getAttachmentManager()
    {
        return $this->uploadManager;
    }

    /**
     * @param AttachmentManagerInterface $uploadManager
     * @return self
     */
    public function setAttachmentManager(AttachmentManagerInterface $uploadManager)
    {
        $this->uploadManager = $uploadManager;

        return $this;
    }
}
