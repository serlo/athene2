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

interface FlagManagerAwareInterface
{

    /**
     * @return FlagManagerInterface
     */
    public function getFlagManager();

    /**
     * @param FlagManagerInterface $flagManager
     * @return self
     */
    public function setFlagManager(FlagManagerInterface $flagManager);
}
