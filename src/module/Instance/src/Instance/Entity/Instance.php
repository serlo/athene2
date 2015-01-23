<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Instance\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="instance")
 */
class Instance implements InstanceInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=2)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $subdomain;

    /**
     * @ORM\ManyToOne(targetEntity="Instance\Entity\Language")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     * @var LanguageInterface
     */
    protected $language;

    public function __toString()
    {
        return $this->getName();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($code)
    {
        $this->name = $code;
    }

    public function getSubdomain()
    {
        return $this->subdomain;
    }

    public function setSubdomain($subdomain)
    {
        $this->subdomain = $subdomain;
    }
}
