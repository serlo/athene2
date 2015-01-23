<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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
