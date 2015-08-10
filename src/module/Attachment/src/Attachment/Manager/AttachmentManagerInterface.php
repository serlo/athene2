<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Attachment\Manager;

use Attachment\Entity\ContainerInterface;
use Attachment\Entity\FileInterface;
use Attachment\Form\AttachmentFieldsetProvider;
use Common\ObjectManager\Flushable;

interface AttachmentManagerInterface extends Flushable
{
    /**
     * @param AttachmentFieldsetProvider $form
     * @param string                     $type
     * @param int                        $appendId
     * @return ContainerInterface
     */
    public function attach(AttachmentFieldsetProvider $form, $type = 'file', $appendId = null);

    /**
     * @param int $id
     * @return ContainerInterface
     */
    public function getAttachment($id);

    /**
     * @param $attachmentId $id
     * @param $fileId       $id
     * @return FileInterface
     */
    public function getFile($attachmentId, $fileId = null);
}
