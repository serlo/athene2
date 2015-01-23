<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Jakob Pfab (jakob.pfab@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ads\Hydrator;

use Ads\Entity\AdInterface;
use Ads\Exception;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\Hydrator\HydratorInterface;

class AdHydrator implements HydratorInterface
{

    protected $keys = [
        'author',
        'title',
        'content',
        'attachment',
        'instance',
        'frequency',
        'url'
    ];

    public function extract($object)
    {
        $data = [];
        foreach ($this->keys as $key) {
            $method      = 'get' . ucfirst($key);
            $data['key'] = $object->$method();
        }

        return $data;
    }

    public function hydrate(array $data, $object)
    {
        $data = ArrayUtils::merge($this->extract($object), $data);

        if (!$object instanceof AdInterface) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Expected object to be AdInterface but got "%s"',
                get_class($object)
            ));
        }

        foreach ($this->keys as $key) {
            $method = 'set' . ucfirst($key);
            $value  = $this->getKey($data, $key);
            if ($value !== null) {
                $object->$method($value);
            }
        }

        return $object;
    }

    protected function getKey(array $data, $key)
    {
        return array_key_exists($key, $data) ? $data[$key] : null;
    }
}
