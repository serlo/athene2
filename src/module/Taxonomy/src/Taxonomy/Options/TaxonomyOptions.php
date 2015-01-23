<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Taxonomy\Options;

use Zend\Stdlib\AbstractOptions;

class TaxonomyOptions extends AbstractOptions
{

    protected $allowedChildren = [];

    protected $allowedParents = [];

    protected $rootable;

    protected $allowedAssociations = [];

    /**
     * @return array $allowedChildren
     */
    public function getAllowedChildren()
    {
        return $this->allowedChildren;
    }

    /**
     * @param array $allowedChildren
     * @return self
     */
    public function setAllowedChildren(array $allowedChildren)
    {
        $this->allowedChildren = $allowedChildren;
        return $this;
    }

    /**
     * @return array $allowedParents
     */
    public function getAllowedParents()
    {
        return $this->allowedParents;
    }

    /**
     * @param array $allowedParents
     * @return self
     */
    public function setAllowedParents($allowedParents)
    {
        $this->allowedParents = $allowedParents;
        return $this;
    }

    /**
     * @param string $association
     * @return boolean
     */
    public function isAssociationAllowed($association)
    {
        foreach ($this->getAllowedAssociations() as $allowedAssociation) {
            if ($association === $allowedAssociation || $association instanceof $allowedAssociation) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return array $allowedAssociations
     */
    public function getAllowedAssociations()
    {
        return $this->allowedAssociations;
    }

    /**
     * @param array $allowedAssociations
     * @return self
     */
    public function setAllowedAssociations($allowedAssociations)
    {
        $this->allowedAssociations = $allowedAssociations;
        return $this;
    }

    /**
     * @param string $child
     * @return boolean
     */
    public function isChildAllowed($child)
    {
        return in_array($child, $this->allowedChildren);
    }

    /**
     * @param string $parent
     * @return boolean
     */
    public function isParentAllowed($parent)
    {
        return in_array($parent, $this->allowedParents);
    }

    /**
     * @return bool $rootable
     */
    public function isRootable()
    {
        return $this->rootable;
    }

    /**
     * @param bool $rootable
     * @return self
     */
    public function setRootable($rootable)
    {
        $this->rootable = $rootable;
        return $this;
    }
}
