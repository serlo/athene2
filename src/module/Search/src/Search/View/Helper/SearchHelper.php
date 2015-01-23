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
namespace Search\View\Helper;

use Zend\View\Helper\AbstractHelper;

class SearchHelper extends AbstractHelper
{
    /**
     * @return self
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @param string $query
     * @param string $content
     * @return string
     */
    public function highlight($query, $content)
    {
        $parts = explode(' ', $query);
        foreach ($parts as $part) {
            $pos = stripos($content, $part);
            if ($pos !== false) {
                $a       = substr($content, 0, $pos);
                $b       = substr($content, $pos, strlen($part));
                $c       = substr($content, $pos + strlen($part));
                $content = $a . '<strong>' . $b . '</strong>' . $c;
            }
        }
        return $content;
    }
}
