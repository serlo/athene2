<?php
namespace Ui\Renderer;

use Zend\View\Exception;
use Zend\View\Model\ModelInterface as Model;
use Zend\View\Renderer\PhpRenderer;

class PhpDebugRenderer extends PhpRenderer
{
    public function render($nameOrModel, $values = null)
    {
        $template = $nameOrModel;
        $disable  = false;
        if ($nameOrModel instanceof Model) {
            $template = $nameOrModel->getTemplate();
            $disable  = $nameOrModel->getVariable('__disableTemplateDebugger', false);
        }

        $output = parent::render($nameOrModel, $values);

        if ($disable) {
            return $output;
        }

        return '<!-- template-identity: ' . $template . ' -->' . $output; // filter output
    }
}
