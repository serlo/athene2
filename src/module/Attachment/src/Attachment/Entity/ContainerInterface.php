<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Attachment\Entity;

use Instance\Entity\InstanceAwareInterface;
use Type\Entity\TypeAwareInterface;
use Doctrine\Common\Collections\Collection;

interface ContainerInterface extends InstanceAwareInterface, TypeAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return FileInterface[]|Collection
     */
    public function getFiles();

    /**
     * @param FileInterface $file
     * @return void
     */
    public function addFile(FileInterface $file);

    /**
     * @return FileInterface
     */
    public function getFirstFile();
}
