<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Common\Traits;

use Zend\Stdlib\ArrayUtils;

trait ConfigAwareTrait
{
    abstract protected function getDefaultConfig();

    protected $config = [];

    /**
     * @return field_type $config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param field_type $config
     * @return self
     */
    public function setConfig(array $config)
    {
        $this->config = ArrayUtils::merge($this->getDefaultConfig(), $config);

        $array = [
            $this->getDefaultConfig(),
            $config,
            $this->config,
        ];

        return $this;
    }

    public function appendConfig(array $config)
    {
        $this->config = ArrayUtils::merge($this->config, $config);

        return $this;
    }

    public function getOption($key)
    {
        if (array_key_exists($key, $this->getConfig())) {
            return $this->getConfig()[$key];
        } else {
            $this->setConfig([]);
            if (array_key_exists($key, $this->getConfig())) {
                return $this->getConfig()[$key];
            } else {
                return null;
            }
        }
    }
}
