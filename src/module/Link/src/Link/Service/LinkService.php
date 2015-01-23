<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
namespace Link\Service;

use Authorization\Service\AuthorizationAssertionTrait;
use Common\Traits\ObjectManagerAwareTrait;
use Link\Entity\LinkableInterface;
use Link\Entity\LinkInterface;
use Link\Exception;
use Link\Options\LinkOptionsInterface;
use Type\Entity\TypeInterface;
use Type\TypeManagerAwareTrait;
use Zend\EventManager\EventManagerAwareTrait;

class LinkService implements LinkServiceInterface
{
    use ObjectManagerAwareTrait, TypeManagerAwareTrait;
    use AuthorizationAssertionTrait, EventManagerAwareTrait;

    public function associate(
        LinkableInterface $parent,
        LinkableInterface $child,
        LinkOptionsInterface $parentOptions,
        $position = 0
    ) {
        $this->assertGranted($parentOptions->getPermission('create'), $child);

        $this->isValidChild($parent, $child, $parentOptions);

        $typeName = $parentOptions->getLinkType();
        $type     = $this->getTypeManager()->findTypeByName($typeName);
        $link     = $parent->createLink();

        $link->setParent($parent);
        $link->setChild($child);
        $link->setType($type);
        $link->setPosition($position);

        $this->getEventManager()->trigger(
            'link',
            $this,
            [
                'entity' => $child,
                'parent' => $parent
            ]
        );

        $this->getObjectManager()->persist($link);

        return $this;
    }

    public function dissociate(
        LinkableInterface $parent,
        LinkableInterface $child,
        LinkOptionsInterface $parentOptions,
        $position = 0
    ) {
        $this->assertGranted($parentOptions->getPermission('purge'), $child);

        $typeName = $parentOptions->getLinkType();
        $type     = $this->getTypeManager()->findTypeByName($typeName);
        $link     = $this->findLinkByChild($parent, $child->getId(), $type);

        if (is_object($link)) {

            $this->getEventManager()->trigger(
                'unlink',
                $this,
                [
                    'entity' => $child,
                    'parent' => $parent
                ]
            );

            $this->getObjectManager()->remove($link);
        }

        return $this;
    }

    public function sortChildren(LinkableInterface $parent, $typeName, array $children)
    {
        $type = $this->getTypeManager()->findTypeByName($typeName);
        $i    = 0;

        foreach ($children as $child) {
            if ($child instanceof LinkableInterface) {
                $child = $child->getId();
            }

            $link = $this->findLinkByChild($parent, $child, $type);

            if ($link !== null) {
                $link->setPosition($i);
                $this->getObjectManager()->persist($link);
            }
            $i++;
        }

        return $this;
    }

    public function sortParents(LinkableInterface $child, $typeName, array $parents)
    {
        $type = $this->getTypeManager()->findTypeByName($typeName);
        $i    = 0;

        foreach ($parents as $parent) {
            if ($parent instanceof LinkableInterface) {
                $parent = $parent->getId();
            }
            $link = $this->findLinkByChild($child, $parent, $type);

            if ($link !== null) {
                $link->setPosition($i);
                $this->getObjectManager()->persist($link);
            }
            $i++;
        }

        return $this;
    }

    protected function findLinkByChild(LinkableInterface $element, $childId, TypeInterface $type)
    {
        /* @var $link LinkInterface */
        foreach ($element->getChildLinks() as $link) {
            if ($link->getChild()->getId() == $childId && $link->getType() === $type) {
                return $link;
            }
        }

        return null;
    }

    protected function findLinkByParent(LinkableInterface $element, $parentId, TypeInterface $type)
    {
        /* @var $link LinkInterface */
        foreach ($element->getParentLinks() as $link) {
            if ($link->getParent()->getId() === $parentId && $link->getType() === $type) {
                return $link;
            }
        }

        return null;
    }

    protected function isValidChild(LinkableInterface $parent, LinkableInterface $child, LinkOptionsInterface $options)
    {
        $childType  = $child->getType()->getName();
        $parentType = $parent->getType()->getName();

        if (!$options->isChildAllowed($childType)) {
            throw new Exception\RuntimeException(sprintf('Child type "%s" is not allowed.', $childType));
        }

        if (!$options->allowsManyChildren($childType)) {
            /* @var $childLink \Link\Entity\LinkInterface */
            foreach ($parent->getChildLinks() as $childLink) {
                if ($childLink->getChild()->getType()->getName() == $childType
                ) {
                    throw new Exception\RuntimeException(sprintf(
                        'Child type "%s" does not allow multiple children.',
                        $childType
                    ));
                }
            }
        }

        return true;
    }
}
