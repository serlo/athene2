<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Attachment\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Instance\Entity\InstanceAwareTrait;
use Type\Entity\TypeAwareTrait;
use Uuid\Entity\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="attachment_container")
 */
class Container extends Uuid implements ContainerInterface
{
    use TypeAwareTrait;
    use InstanceAwareTrait;

    /**
     * @ORM\OneToMany(targetEntity="File", mappedBy="attachment")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $files;

    public function __construct()
    {
        $this->files = new ArrayCollection;
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function getFirstFile()
    {
        return $this->files->first();
    }

    public function addFile(FileInterface $file)
    {
        $this->files->add($file);
    }
}
