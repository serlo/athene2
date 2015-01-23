<?php
/**
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @copyright 2013 by www.serlo.org
 * @license   LGPL
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 */
namespace Versioning\Entity;

use User\Entity\UserInterface;

interface RevisionInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * Returns the repository
     *
     * @return RepositoryInterface
     */
    public function getRepository();

    /**
     * Sets the repository
     *
     * @param RepositoryInterface $repository
     * @return self
     */
    public function setRepository(RepositoryInterface $repository);

    /**
     * Sets the author
     *
     * @param UserInterface $user
     * @return self
     */
    public function setAuthor(UserInterface $user);

    /**
     * @param bool $trash
     * @return void
     */
    public function setTrashed($trash);

    /**
     * @return bool
     */
    public function isTrashed();
}
