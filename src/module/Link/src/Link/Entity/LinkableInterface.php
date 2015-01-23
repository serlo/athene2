<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
namespace Link\Entity;

use Type\Entity\TypeInterface;

interface LinkableInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @return TypeInterface
     */
    public function getType();

    /**
     * @return LinkInterface
     */
    public function createLink();

    /**
     * @return LinkInterface[]
     */
    public function getParentLinks();

    /**
     * @return LinkInterface[]
     */
    public function getChildLinks();
}
