<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Entity\Options;

use Entity\Exception;
use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $types = [];

    /**
     * @param string $type
     * @return EntityOptions
     * @throws Exception\RuntimeException
     */
    public function getType($type)
    {
        if (!array_key_exists($type, $this->types)) {
            throw new Exception\RuntimeException(sprintf('Type "%s" not found.', $type));
        }

        $options = $this->types[$type];

        if (!$options instanceof EntityOptions) {
            $options            = new EntityOptions($options);
            $options->setName($type);

            $this->types[$type] = $options;
        }

        return $options;
    }

    /**
     * @return array|EntityOptions[]
     */
    public function getTypes()
    {
        $types = [];
        foreach ($this->types as $type => $options) {
            $types[] = $this->getType($type);
        }
        return $types;
    }

    /**
     * @param array $types
     * @return void
     */
    public function setTypes(array $types)
    {
        $this->types = $types;
    }
}
