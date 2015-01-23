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
namespace Normalizer\Entity;

use DateTime;
use Zend\Stdlib\AbstractOptions;

class Metadata extends AbstractOptions implements MetadataInterface
{
    /**
     * @var string
     */
    protected $author;

    /**
     * @var DateTime
     */
    protected $lastModified;

    /**
     * @var string
     */
    protected $context;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var DateTime
     */
    protected $creationDate;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $languageCode;
    /**
     * @var string
     */
    protected $license;

    /**
     * @var array|string[]
     */
    protected $keywords = [];

    public function __construct(array $data)
    {
        $this->creationDate = new DateTime();
        $this->lastModified = new DateTime();
        parent::__construct($data);
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param string $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param DateTime $timestamp
     */
    public function setCreationDate(DateTime $timestamp)
    {
        $this->creationDate = $timestamp;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return array|\string[]
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param array|string[] $keywords
     */
    public function setKeywords(array $keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return string
     */
    public function getLanguageCode()
    {
        return $this->languageCode;
    }

    /**
     * @param string $languageCode
     */
    public function setLanguageCode($languageCode)
    {
        $this->languageCode = $languageCode;
    }

    /**
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * @param DateTime $lastModified
     */
    public function setLastModified(DateTime $lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     * @return string
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @param string $license
     */
    public function setLicense($license)
    {
        $this->license = $license;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
