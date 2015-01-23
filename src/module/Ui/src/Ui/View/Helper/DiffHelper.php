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

use Zend\View\Helper\AbstractHelper;

class DiffHelper extends AbstractHelper
{
    public function __invoke()
    {
        return $this;
    }

    function html($old, $new)
    {
        $old = strip_tags($old);
        $new = strip_tags($new);
        $diff = $this->text(explode(' ', $old), explode(' ', $new));
        $ret  = '';
        foreach ($diff as $k) {
            if (is_array($k)) {
                $ret .= (!empty($k['d']) ? "<del class=\"text-muted diff\">" . implode(' ', $k['d']) . "</del> " :
                        '') . (!empty($k['i']) ?
                        "<ins class=\"text-success diff\">" . implode(' ', $k['i']) . "</ins> " : '');
            } else {
                $ret .= $k . ' ';
            }
        }
        return $ret;
    }

    function markdown($old, $new)
    {
        $pattern = '@[{"col":[0-9]+,"content":"@is';
        $old     = preg_replace($pattern, "", $old);
        $new     = preg_replace($pattern, "", $new);
        $pattern = '@"},|"}],|"}]]@is';
        $old     = preg_replace($pattern, "\n", $old);
        $new     = preg_replace($pattern, "\n", $new);
        $out     = $this->html($old, $new);
        $out     = preg_replace('@\\n|\\\\n@is', '<br>', $out);
        $out     = preg_replace('@\\\\@is', '\\', $out);
        return $out;
    }

    function text($old, $new)
    {
        $maxlen = $omax = $nmax = 0;
        foreach ($old as $oindex => $ovalue) {
            $nkeys = array_keys($new, $ovalue);
            foreach ($nkeys as $nindex) {
                $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                    $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
                if ($matrix[$oindex][$nindex] > $maxlen) {
                    $maxlen = $matrix[$oindex][$nindex];
                    $omax   = $oindex + 1 - $maxlen;
                    $nmax   = $nindex + 1 - $maxlen;
                }
            }
        }
        if ($maxlen == 0) {
            return array(array('d' => $old, 'i' => $new));
        }
        return array_merge(
            $this->text(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
            array_slice($new, $nmax, $maxlen),
            $this->text(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen))
        );
    }
}
