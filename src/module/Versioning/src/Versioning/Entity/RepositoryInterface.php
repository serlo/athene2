<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
namespace Versioning\Entity;

use Doctrine\Common\Collections\Collection;

interface RepositoryInterface
{
    /**
     * @param RevisionInterface $revision
     * @return void
     */
    public function addRevision(RevisionInterface $revision);

    /**
     * Creates a new revision
     *
     * @return RevisionInterface
     */
    public function createRevision();

    /**
     * @return RevisionInterface
     */
    public function getCurrentRevision();

    /**
     * @return int
     */
    public function getId();

    /**
     * Returns the revisions
     *
     * @return Collection|RevisionInterface[]
     */
    public function getRevisions();

    /**
     * @return bool
     */
    public function hasCurrentRevision();

    /**
     * @param RevisionInterface $revision
     * @return void
     */
    public function removeRevision(RevisionInterface $revision);

    /**
     * @param RevisionInterface $revision
     * @return void
     */
    public function setCurrentRevision(RevisionInterface $revision);
}
