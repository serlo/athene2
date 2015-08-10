<?php
/**
 *
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author        Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Subject\Options;

use Subject\Exception;
use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    /**
     *
     * @var array
     */
    protected $instances = [];

    /**

     * @param string $name
     * @param string $instance
     * @throws Exception\RuntimeException
     * @return SubjectOptions
     */
    public function getInstance($name, $instance)
    {
        $name = strtolower($name);
        $instance = strtolower($instance);

        if (!array_key_exists($instance, $this->instances)) {
            throw new Exception\RuntimeException(sprintf('Instance "%s" unknown.', $instance));
        }

        if (!array_key_exists($name, $this->instances[$instance])) {
            throw new Exception\RuntimeException(sprintf('Subject "%s" unknown.', $name));
        }

        $options = $this->instances[$instance][$name];
        return new SubjectOptions($options);
    }

    /**
     *
     * @param array $instances
     * @return self
     */
    public function setInstances(array $instances)
    {
        $this->instances = $instances;
        return $this;
    }
}
