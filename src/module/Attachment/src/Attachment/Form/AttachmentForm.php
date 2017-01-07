<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Attachment\Form;

use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Csrf;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class AttachmentForm extends Form implements AttachmentFieldsetProvider
{
    public function __construct()
    {
        parent::__construct('upload');
        $this->add(new Csrf('attachment_csrf'));

        $filter = new InputFilter();

        $this->setInputFilter($filter);
        $this->setAttribute('class', 'clearfix');

        $this->add(new AttachmentFieldset());
        $this->add(
            (new Select('type'))->setLabel('Set type:')->setValueOptions(['file' => 'File', 'geogebra' => 'Geogebra'])
        );
        $this->add(
            (new Submit('submit'))->setValue('Upload')->setAttribute('class', 'btn btn-success pull-right')
        );

        $filter->add(['name' => 'type', 'required' => true]);
    }
}
