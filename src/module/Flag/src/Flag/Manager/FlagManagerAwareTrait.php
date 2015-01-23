<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
