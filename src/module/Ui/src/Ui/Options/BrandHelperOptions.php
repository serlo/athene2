<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ui\Options;

use Zend\Stdlib\AbstractOptions;

class BrandHelperOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $instances = [];

    /**
     * @param string $key
     * @return BrandHelperInstanceOptions
     */
    public function getInstance($key)
    {
        $key = strtolower($key);

        if (!isset($this->instances[$key])) {
            $this->instances[$key] = [];
        }

        if (!is_object($this->instances[$key])) {
            $options               = $this->instances[$key];
            $this->instances[$key] = new BrandHelperInstanceOptions($options);
        }

        return $this->instances[$key];
    }

    /**
     * @return array
     */
    public function getInstances()
    {
        return $this->instances;
    }

    /**
     * @param array $instances
     */
    public function setInstances(array $instances)
    {
        $this->instances = $instances;
    }
}
