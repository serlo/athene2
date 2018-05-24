<?php
namespace Ui\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class AssetsHost extends AbstractHelper
{
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function __invoke()
    {
        return $this->config['assets_host'];
    }
}
