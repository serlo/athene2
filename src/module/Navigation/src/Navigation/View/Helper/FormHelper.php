<?php/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Benjamin Knorr (benjamin@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Navigation\View\Helper;

use Navigation\Form\CreatePageForm;
use Navigation\Form\RemoveContainerForm;
use Navigation\Form\RemovePageForm;
use Navigation\Form\RemoveParameterForm;
use Zend\Form\Form;
use Zend\View\Helper\AbstractHelper;

class FormHelper extends AbstractHelper
{
    public function __invoke()
    {
        return $this;
    }

    public function getCreatePageForm($containerId, $parentId = null) {
        $url = $this->getView()->url('navigation/page/create', ['container' => $containerId, 'parent' => $parentId]);
        /** @var Form $form */
        $form = new CreatePageForm();
        $form->setAttribute('action', $url);
        return $form;
    }

    public function getRemoveContainerForm($containerId)
    {
        $url = $this->getView()->url('navigation/container/remove', ['container' => $containerId]);
        /** @var Form $form */
        $form = new RemoveContainerForm();
        $form->setAttribute('action', $url);
        return $form;
    }

    public function getRemovePageForm($pageId)
    {
        $url = $this->getView()->url('navigation/page/remove', ['page' => $pageId]);
        /** @var Form $form */
        $form = new RemovePageForm();
        $form->setAttribute('action', $url);
        return $form;
    }

    public function getRemoveParameterForm($parameterId)
    {
        $url = $this->getView()->url('navigation/parameter/remove', ['parameter' => $parameterId]);
        /** @var Form $form */
        $form = new RemoveParameterForm();
        $form->setAttribute('action', $url);
        return $form;
    }
}
