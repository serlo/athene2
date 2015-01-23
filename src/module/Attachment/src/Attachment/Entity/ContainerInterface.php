<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
