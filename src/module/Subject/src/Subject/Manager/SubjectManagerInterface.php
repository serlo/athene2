<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Subject\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Entity\Entity\EntityInterface;
use Instance\Entity\InstanceInterface;
use Taxonomy\Entity\TaxonomyTermInterface;

interface SubjectManagerInterface
{

    /**
     * @param string            $name
     * @param InstanceInterface $instance
     * @return TaxonomyTermInterface
     */
    public function findSubjectByString($name, InstanceInterface $instance);

    /**
     * @param InstanceInterface $instance
     * @return ArrayCollection|TaxonomyTermInterface[]
     */
    public function findSubjectsByInstance(InstanceInterface $instance);

    /**
     * @param int $id
     * @return TaxonomyTermInterface
     */
    public function getSubject($id);

    /**
     * @param TaxonomyTermInterface $subject
     * @return EntityInterface[]
     */
    public function getUnrevisedRevisions(TaxonomyTermInterface $subject);

    /**
     * @param TaxonomyTermInterface $subject
     * @return EntityInterface[]
     */
    public function getTrashedEntities(TaxonomyTermInterface $subject);
}
