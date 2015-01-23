<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Term\Manager;

interface TermManagerAwareInterface
{
    /**
     * Returns the TermManager.
     *
     * @return TermManagerInterface
     */
    public function getTermManager();

    /**
     * Sets the TermManager.
     *
     * @param TermManagerInterface $termManager
     * @return void
     */
    public function setTermManager(TermManagerInterface $termManager);
}
