<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Taxonomy\Entity;

use Doctrine\Common\Collections\Collection;
use Instance\Entity\InstanceAwareInterface;
use Type\Entity\TypeAwareInterface;

interface TaxonomyInterface extends TypeAwareInterface, InstanceAwareInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @return TaxonomyTermInterface[]|Collection
     */
    public function getTerms();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return TaxonomyTermInterface[]|Collection
     */
    public function getChildren();
}
