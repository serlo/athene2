<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace License\Entity;

use Doctrine\ORM\Mapping as ORM;
use Instance\Entity\InstanceAwareTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="license")
 */
class License implements LicenseInterface
{
    use InstanceAwareTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string")
     */
    protected $url;

    /**
     * @ORM\Column(type="boolean", name="`default`")
     */
    protected $default;

    /**
     * @ORM\Column(type="string")
     */
    protected $content;

    /**
     * @ORM\Column(type="string")
     */
    protected $agreement;

    /**
     * @ORM\Column(type="string", name="icon_href")
     */
    protected $iconHref;

    /**
     * @return string
     */
    public function getAgreement()
    {
        return $this->agreement;
    }

    /**
     * @param string $agreement
     */
    public function setAgreement($agreement)
    {
        $this->agreement = $agreement;
    }

    /**
     * @return string $iconHref
     */
    public function getIconHref()
    {
        return $this->iconHref;
    }

    /**
     * @param string $iconHref
     * @return void
     */
    public function setIconHref($iconHref)
    {
        $this->iconHref = $iconHref;
    }

    /**
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;


    }

    /**
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;


    }

    /**
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return boolean
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * @param boolean $default
     */
    public function setDefault($default)
    {
        $this->default = (boolean)$default;
    }
}
