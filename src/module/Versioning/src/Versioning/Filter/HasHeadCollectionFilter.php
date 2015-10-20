<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Jonas Keinholz (jonas.keinholz@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Versioning\Filter;

use Doctrine\Common\Collections\Collection;
use Versioning\Entity\RepositoryInterface;
use Zend\Filter\Exception;
use Zend\Filter\FilterInterface;

class HasHeadCollectionFilter implements FilterInterface
{
    /**
     * Returns the result of filtering $value
     *
     * @param  mixed $value
     * @throws Exception\RuntimeException If filtering $value is impossible
     * @return mixed
     */
    public function filter($value)
    {
        if (!$value instanceof Collection) {
            throw new Exception\RuntimeException(sprintf(
                'Expected Collection but got %s',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        return $value->filter(
            function (RepositoryInterface $repository) {
                return $repository->hasHead();
            }
        );
    }
}
