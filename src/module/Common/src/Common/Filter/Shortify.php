<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Common\Filter;

use Zend\Filter\FilterInterface;

class Shortify implements FilterInterface
{
    /**
     * @param string $text
     * @return bool|mixed
     */
    static protected function shortify($text)
    {
        $text = preg_replace('@-(\w{1,3})-@isU', '-', $text);
        $text = preg_replace('@-(\w{1,3})/@isU', '/', $text);
        $text = preg_replace('@/(\w{1,3})-@isU', '/', $text);

        if (empty($text)) {
            return false;
        }

        return $text;
    }

    /**
     * {@inheritDoc}
     */
    public function filter($value)
    {
        return self::shortify($value);
    }
}
