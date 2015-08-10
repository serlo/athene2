<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Entity\Filter;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Entity\Entity\EntityInterface;
use Entity\Entity\RevisionInterface;
use Zend\Filter\Exception;
use Zend\Filter\FilterInterface;

class EntityAgeCollectionFilter implements FilterInterface
{
    /**
     * @var DateTime
     */
    protected $maxAge;

    public function __construct(DateTime $maxAge)
    {
        $this->maxAge = $maxAge;
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
        if (!$value instanceof Collection) {
            throw new Exception\RuntimeException(sprintf(
                'Expected instance of Collection but got %s',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        return $value->filter(
            function (EntityInterface $entity) {
                /* @var $revision RevisionInterface */
                $revision = $entity->getCurrentRevision();

                if (!$revision) {
                    return false;
                }

                return $revision->getTimestamp() > $this->maxAge;
            }
        );
    }
}
