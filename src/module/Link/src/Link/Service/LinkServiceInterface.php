<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
namespace Link\Service;

use Link\Entity\LinkableInterface;
use Link\Options\LinkOptionsInterface;

interface LinkServiceInterface
{

    /**
     * @param LinkableInterface    $parent
     * @param LinkableInterface    $child
     * @param LinkOptionsInterface $parentOptions
     * @param number               $position
     * @return self
     */
    public function associate(
        LinkableInterface $parent,
        LinkableInterface $child,
        LinkOptionsInterface $parentOptions,
        $position = 0
    );

    /**
     * @param LinkableInterface    $parent
     * @param LinkableInterface    $child
     * @param LinkOptionsInterface $parentOptions
     * @param number               $position
     * @return self
     */
    public function dissociate(
        LinkableInterface $parent,
        LinkableInterface $child,
        LinkOptionsInterface $parentOptions,
        $position = 0
    );

    /**
     * @param LinkableInterface $parent
     * @param string            $typeName
     * @param array             $children
     * @return self
     */
    public function sortChildren(LinkableInterface $parent, $typeName, array $children);

    /**
     * @param LinkableInterface $child
     * @param string            $typeName
     * @param array             $parents
     * @return self
     */
    public function sortParents(LinkableInterface $child, $typeName, array $parents);
}
