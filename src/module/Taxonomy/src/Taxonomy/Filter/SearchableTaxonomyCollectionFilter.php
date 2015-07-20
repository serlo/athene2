<?php
/**
 * Created by PhpStorm.
 * User: benny
 * Date: 20.07.15
 * Time: 13:59
 */
namespace Taxonomy\Filter;

use Taxonomy\Entity\TaxonomyTermInterface;
use Doctrine\Common\Collections\Collection;
use Zend\Filter\Exception;
use Zend\Filter\FilterInterface;

class SearchableTaxonomyCollectionFilter implements FilterInterface
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
            function (TaxonomyTermInterface $term) {
                $type = $term->getType()->getName();
                return  $type != 'curriculum-topic' && $type != 'curriculum-topic-folder';
            }
        );
    }
}