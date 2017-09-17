<?php
namespace Ui\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class PreRelease extends AbstractHelper
{
    public function __invoke()
    {
        return isset($_COOKIE['prerelease']) && $_COOKIE['prerelease'] === 'true';
    }
}
