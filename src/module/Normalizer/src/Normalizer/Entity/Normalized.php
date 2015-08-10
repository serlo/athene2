<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Normalizer\Entity;

use Zend\Stdlib\AbstractOptions;

class Normalized extends AbstractOptions implements NormalizedInterface
{
    /**
     * @var MetadataInterface|array
     */
    protected $metadata;

    /**
     * @var string
     */
    protected $routeName;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $routeParams;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var int
     */
    protected $id;

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getMetadata()
    {
        if (!is_object($this->metadata)) {
            $this->metadata = new Metadata($this->metadata);
        }
        return $this->metadata;
    }

    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }

    public function getRouteName()
    {
        return $this->routeName;
    }

    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;
    }

    public function getRouteParams()
    {
        return $this->routeParams;
    }

    public function setRouteParams($routeParams)
    {
        $this->routeParams = $routeParams;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
}
