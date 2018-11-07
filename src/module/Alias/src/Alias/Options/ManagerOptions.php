<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Alias\Options;

use Zend\Stdlib\AbstractOptions;

class ManagerOptions extends AbstractOptions
{
    protected $aliases = [];

    /**
     * @return array $aliases
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * @param array $aliases
     * @return void
     */
    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }
}
