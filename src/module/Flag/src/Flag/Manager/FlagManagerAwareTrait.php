<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Flag\Manager;

trait FlagManagerAwareTrait
{

    /**
     * @var FlagManagerInterface
     */
    protected $flagManager;

    /**
     * @return FlagManagerInterface $flagManager
     */
    public function getFlagManager()
    {
        return $this->flagManager;
    }

    /**
     * @param FlagManagerInterface $flagManager
     * @return self
     */
    public function setFlagManager(FlagManagerInterface $flagManager)
    {
        $this->flagManager = $flagManager;

        return $this;
    }
}
