<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Term\Manager;

trait TermManagerAwareTrait
{
    /**
     * @var TermManagerInterface
     */
    protected $termManager;

    /**
     * @return TermManagerInterface
     */
    public function getTermManager()
    {
        return $this->termManager;
    }

    /**
     * @param TermManagerInterface $termManager
     * @return self
     */
    public function setTermManager(TermManagerInterface $termManager)
    {
        $this->termManager = $termManager;
    }
}
