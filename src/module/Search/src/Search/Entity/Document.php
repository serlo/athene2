<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Search\Entity;

class Document implements DocumentInterface
{

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $keywords;

    /**
     * @var int|null
     */
    protected $instance;

    /**
     * @param int      $id
     * @param string   $title
     * @param string   $content
     * @param string   $type
     * @param string   $link
     * @param array    $keywords
     * @param int|null $instance
     */
    public function __construct(
        $id,
        $title,
        $content,
        $type,
        $link,
        array $keywords,
        $instance = null
    ) {
        $this->id       = $id;
        $this->title    = $title;
        $this->content  = $content;
        $this->type     = $type;
        $this->link     = $link;
        $this->keywords = $keywords;
        $this->instance = $instance;
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * {@inheritDoc}
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * {@inheritDoc}
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return [
            'id'       => $this->getId(),
            'title'    => $this->getTitle(),
            'content'  => $this->getContent(),
            'link'     => $this->getLink(),
            'type'     => $this->getType(),
            'keywords' => $this->getKeywords()
        ];
    }
}
