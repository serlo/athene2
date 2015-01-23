<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Event\Filter;

use ArrayIterator;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectManager;
use Event\Entity\EventLogInterface;
use Zend\Filter\Exception;
use Zend\Filter\FilterInterface;

class PersistentParameterFilter implements FilterInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Returns the result of filtering $value
     *
     * @param  mixed $value
     * @throws Exception\RuntimeException If filtering $value is impossible
     * @return mixed
     */
    public function filter($value)
    {
        $passes = function (EventLogInterface $eventLog) {
            foreach ($eventLog->getParameters() as $parameter) {
                if ($parameter->getValue() === null) {
                    //$this->objectManager->remove($eventLog);
                    //$this->objectManager->flush($eventLog);
                    return false;
                }
            }

            return true;
        };

        if ($value instanceof Collection) {
            return $value->filter($passes);
        } elseif ($value instanceof \Iterator) {
            return new ArrayIterator(array_filter(iterator_to_array($value), $passes));
        } elseif (is_array($value)) {
            return array_filter($value, $passes);
        } else {
            throw new Exception\RuntimeException(sprintf(
                'Expected Collection or array but got %s',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }
    }
}
