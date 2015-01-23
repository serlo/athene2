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
