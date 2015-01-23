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
namespace Blog\Filter;

use Blog\Entity\PostInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zend\Filter\Exception;
use Zend\Filter\FilterInterface;

class PostUnpublishedFilter implements FilterInterface
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
        $result = [];

        if (!$value instanceof Collection) {
            throw new Exception\RuntimeException(sprintf(
                'Expected instance of Collection but got %s.',
                is_object($value) ? get_class($value) : gettype($value)
            ));
        }

        foreach ($value as $post) {
            if (!$post instanceof PostInterface) {
                throw new Exception\RuntimeException(sprintf(
                    'Expected instance of PostInterface but got %s.',
                    is_object($post) ? get_class($post) : gettype($post)
                ));
            }
            if (!$post->isPublished() && !$post->isTrashed()) {
                $result[] = $post;
            }
        }

        return new ArrayCollection($result);
    }
}
