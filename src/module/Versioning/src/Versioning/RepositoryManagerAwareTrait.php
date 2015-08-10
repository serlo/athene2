<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Versioning;

trait RepositoryManagerAwareTrait
{

    /**
     * The RepositoryManager
     *
     * @var RepositoryManagerInterface
     */
    protected $repositoryManager;

    /**
     * Gets the RepositoryManager
     *
     * @return RepositoryManagerInterface $repositoryManager
     */
    public function getRepositoryManager()
    {
        return $this->repositoryManager;
    }

    /**
     * Sets the RepositoryManager
     *
     * @param RepositoryManagerInterface $repositoryManager
     * @return self
     */
    public function setRepositoryManager(RepositoryManagerInterface $repositoryManager)
    {
        $this->repositoryManager = $repositoryManager;
        return $this;
    }
}
