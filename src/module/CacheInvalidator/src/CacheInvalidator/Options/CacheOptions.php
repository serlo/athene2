<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Jakob Pfab (jakob.pfab@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace CacheInvalidator\Options;

use Zend\Stdlib\AbstractOptions;

class CacheOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $listens = [];

    /**
     * @var array
     */
    protected $invalidators = [];

    /**
     * @return array
     */
    public function getInvalidators()
    {
        return $this->invalidators;
    }

    /**
     * @param array $invalidators
     */
    public function setInvalidators(array $invalidators)
    {
        $this->invalidators = $invalidators;
    }

    /**
     * @return array
     */
    public function getListens()
    {
        return $this->listens;
    }

    /**
     * @param array $listens
     */
    public function setListens(array $listens)
    {
        $this->listens = $listens;
    }
}
