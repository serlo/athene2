<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Attachment\Entity;

use Instance\Entity\InstanceProviderInterface;

interface FileInterface extends InstanceProviderInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @return \DateTime
     */
    public function getDateTime();

    /**
     * @return string
     */
    public function getLocation();

    /**
     * @return int
     */
    public function getSize();

    /**
     * @return string
     */
    public function getFilename();

    /**
     * @return string
     */
    public function getType();

    /**
     * @return ContainerInterface
     */
    public function getAttachment();

    /**
     * @param ContainerInterface $attachment
     * @return void
     */
    public function setAttachment(ContainerInterface $attachment);

    /**
     * @param string $location
     * @return void
     */
    public function setLocation($location);

    /**
     * @param int $size
     * @return void
     */
    public function setSize($size);

    /**
     * @param string $filename
     * @return void
     */
    public function setFilename($filename);

    /**
     * @param string $type
     * @return void
     */
    public function setType($type);
}
