<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Common\Filter;

use Zend\Filter\FilterInterface;

class Slugify implements FilterInterface
{
    /**
     * @param string $text
     * @return bool|mixed
     */
    protected static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return false;
        }

        return $text;
    }

    /**
     * @param string $str
     * @param string $delimiter
     * @return mixed|string
     */
    protected static function toAscii($str, $delimiter = '-')
    {
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    /**
     * {@inheritDoc}
     */
    public function filter($value)
    {
        return self::slugify($value);
    }
}
