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
namespace Taxonomy\Hydrator;

use Common\Hydrator\AbstractHydratorPlugin;
use Doctrine\Common\Persistence\ObjectManager;
use Taxonomy\Entity\TaxonomyTermAwareInterface;
use Taxonomy\Manager\TaxonomyManagerInterface;

class TaxonomyTermHydratorPlugin extends AbstractHydratorPlugin
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var TaxonomyManagerInterface
     */
    protected $taxonomyManager;

    public function __construct(ObjectManager $objectManager, TaxonomyManagerInterface $taxonomyManager)
    {
        $this->objectManager   = $objectManager;
        $this->taxonomyManager = $taxonomyManager;
    }

    /**
     * (Partially) hydrates the object and removes the affected (key, value) pairs from the return set.
     *
     * @param object $object
     * @param array  $data
     * @return array
     */
    public function hydrate($object, array $data)
    {
        if (!$object instanceof TaxonomyTermAwareInterface) {
            return $data;
        }

        $metadata = $this->objectManager->getClassMetadata(get_class($object));
        foreach ($data as $field => $value) {
            if ($metadata->hasAssociation($field)) {
                $target = $metadata->getAssociationTargetClass($field);
                if ($target == 'Taxonomy\Entity\TaxonomyTerm') {
                    $this->taxonomyManager->associateWith($value, $object);
                    unset($data[$field]);
                }
            }
        }

        return $data;
    }
}
