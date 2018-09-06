<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Markdown\View\Helper;

use Zend\View\Helper\AbstractHelper;

class OryFormatHelper extends AbstractHelper
{
    public function __invoke($string)
    {
        return $this->isOryEditorFormat($string);
    }

    public function isOryEditorFormat($string)
    {
        $parsed = json_decode($string, true);
        return $parsed !== null && isset($parsed['cells']);
    }
}
