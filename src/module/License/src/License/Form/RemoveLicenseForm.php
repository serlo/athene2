<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace License\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

class RemoveLicenseForm extends Form
{

    /**
     * @param int $id
     */
    function __construct($id)
    {
        parent::__construct('license-remove');
        $this->setAttribute('method', 'post');

        $this->add(new Csrf('license_remove_csrf_' . $id));

        $this->add(
            (new Submit('submit'))->setValue('Trash')->setAttribute('class', 'btn btn-success pull-right')
        );
    }
}