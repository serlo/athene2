<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Jakob Pfab (jakob.pfab@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ads\Entity;

use Attachment\Entity\AttachmentInterface;
use Attachment\Entity\ContainerInterface;
use Attachment\Entity\FileInterface;
use Instance\Entity\InstanceAwareInterface;
use User\Entity\UserInterface;

interface AdInterface extends InstanceAwareInterface
{

    /**
     * Upcounts the click counter
     *
     * @return void
     */
    public function click();

    /**
     * Gets the image.
     *
     * @return ContainerInterface
     */
    public function getAttachment();

    /**
     * Gets the author.
     *
     * @return UserInterface
     */
    public function getAuthor();

    /**
     * Gets the clicks.
     *
     * @return int
     */
    public function getClicks();

    /**
     * Gets the content.
     *
     * @return string
     */
    public function getContent();

    /**
     * Gets the frequency.
     *
     * @return float
     */
    public function getFrequency();

    /**
     * Gets the id.
     *
     * @return int
     */
    public function getId();

    /**
     * Gets the image.
     *
     * @return FileInterface
     */
    public function getImage();

    /**
     * Gets the title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Gets the url.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Gets the banner.
     *
     * @return boolean
     */
    public function getBanner();
}
