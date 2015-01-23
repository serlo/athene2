<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license        LGPL-3.0
 * @license        http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Common\Filter;

use Zend\Filter\FilterInterface;
use Zend\Filter\StripTags;

class PreviewFilter implements FilterInterface
{

    /**
     * @var string
     */
    protected $append;

    /**
     * @var int
     */
    protected $length;

    /**
     * @param int    $length
     * @param string $append
     */
    public function __construct($length = 150, $append = ' ...')
    {
        $this->length = $length;
        $this->append = $append;
    }

    /**
     * @param string $value
     * @return string
     */
    public function filter($value)
    {
        $value     = trim($value);
        $stripTags = new StripTags();
        $value     = $stripTags->filter($value);
        $length    = $this->length;

        if (strlen($value) <= $length) {
            return $value;
        }

        $appendLength = strlen($this->append);
        $length       = $length - $appendLength;
        $words        = explode(' ', $value);
        $return       = '';

        foreach ($words as $word) {
            $word = trim($word);
            if (strlen($return . ' ' . $word) > $length) {
                break;
            }
            $return .= ' ' . $word;
        }

        if (strlen(trim($return)) < 1) {
            return substr($value, 0, $length) . $this->append;
        }

        $return = trim($return) . $this->append;
        $return = preg_replace('/[\$\%]/i', '', $return); // Remove LaTeX Stuff
        // Remove Newlines and Backslashes and trim whitespaces
        $return = preg_replace('/[\n\\\\]/i', ' ', $return);
        $return = preg_replace('/[\s]{2,}/i', ' ', $return);
        return $return;
    }
}
