<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Term\Manager;

use Common\ObjectManager\Flushable;
use Instance\Entity\InstanceInterface;
use Term\Entity\TermEntityInterface;

interface TermManagerInterface extends Flushable
{

    /**
     * @param string            $name
     * @param InstanceInterface $instance
     * @return TermEntityInterface
     */
    public function createTerm($name, InstanceInterface $instance);

    /**
     * @param string           $name
     * @param InstanceInterface $instance
     * @return TermEntityInterface
     */
    public function findTermByName($name, InstanceInterface $instance);

    /**
     * @param int $term
     * @return TermEntityInterface
     */
    public function getTerm($term);
}
