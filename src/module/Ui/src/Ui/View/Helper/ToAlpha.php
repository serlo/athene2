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
namespace Ui\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class ToAlpha extends AbstractHelper
{
    /**
     * Converts a number to alphanumeric
     * 0 -> a
     * 1 -> b
     * 2 -> c
     * ...
     *
     * @param int $number
     * @return string
     */
    public function __invoke($number)
    {
        $alphabet = range('a', 'z');
        array_flip($alphabet);

        if ($number <= 25) {
            return $alphabet[$number];
        } elseif ($number > 25) {
            $dividend = ($number + 1);
            $alpha    = '';
            while ($dividend > 0) {
                $modulo   = ($dividend - 1) % 26;
                $alpha    = $alphabet[$modulo] . $alpha;
                $dividend = floor((($dividend - $modulo) / 26));
            }

            return $alpha;
        }
    }
}
