<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Alias;

trait AliasManagerAwareTrait
{

    /**
     * @var AliasManagerInterface
     */
    protected $aliasManager;

    /**
     * @return AliasManagerInterface $aliasManager
     */
    public function getAliasManager()
    {
        return $this->aliasManager;
    }

    /**
     * @param AliasManagerInterface $aliasManager
     * @return self
     */
    public function setAliasManager(AliasManagerInterface $aliasManager)
    {
        $this->aliasManager = $aliasManager;

        return $this;
    }
}
