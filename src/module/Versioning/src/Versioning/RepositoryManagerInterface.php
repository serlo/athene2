<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Versioning;

use Common\ObjectManager\Flushable;
use Versioning\Entity\RepositoryInterface;
use Versioning\Entity\RevisionInterface;
use Zend\EventManager\EventManagerAwareInterface;

interface RepositoryManagerInterface extends EventManagerAwareInterface, Flushable
{
    /**
     * Check out a revision.
     *
     * <code>
     * $repositoryManager->checkoutRevision($repository, 123, "my reason");
     * </code>
     *
     * @param RepositoryInterface   $repository
     * @param int|RevisionInterface $revision
     * @param string                $reason
     * @return mixed
     * @throws Exception\RevisionNotFoundException
     */
    public function checkoutRevision(RepositoryInterface $repository, $revision, $reason = '');

    /**
     * Creates a new revision and adds it to the repository.
     *
     * <code>
     * $repositoryManager->commitRevision($repository, ['foo' => 'bar', 'acme' => 'bar']);
     * </code>
     *
     * @param RepositoryInterface $repository
     * @param array               $data
     * @return RevisionInterface
     */
    public function commitRevision(RepositoryInterface $repository, array $data);

    /**
     * Finds an revision by its id.
     *
     * <code>
     * $repositoryManager->findRevision($repository, 123);
     * </code>
     *
     * @param RepositoryInterface   $repository
     * @param int|RevisionInterface $id
     * @return RevisionInterface
     * @throws Exception\RevisionNotFoundException
     */
    public function findRevision(RepositoryInterface $repository, $id);

    /**
     * Finds the revision previous to the specified revision.
     *
     * <code>
     * $repositoryManager->findPreviousRevision($repository,$revision);
     * </code>
     *
     * @param RepositoryInterface $repository
     * @param RevisionInterface $revision
     * @return RevisionInterface
     */
    public function findPreviousRevision(RepositoryInterface $repository, RevisionInterface $revision);


    /**
     * Rejects a revision (opposite of checkoutRevision).
     *
     * <code>
     * $repositoryManager->rejectRevision($repository, 123, 'That's spam...');
     * </code>
     *
     * @param RepositoryInterface   $repository
     * @param int|RevisionInterface $revision
     * @param string                $reason
     * @return void
     */
    public function rejectRevision(RepositoryInterface $repository, $revision, $reason = '');
}
