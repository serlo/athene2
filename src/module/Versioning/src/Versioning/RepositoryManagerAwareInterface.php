<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Versioning;

interface RepositoryManagerAwareInterface
{

    /**
     * Set repository manager
     *
     * @param RepositoryManagerInterface $repositoryManager
     */
    public function setRepositoryManager(RepositoryManagerInterface $repositoryManager);

    /**
     * Returns the RepositoryManager
     *
     * @return RepositoryManagerInterface
     */
    public function getRepositoryManager();
}
