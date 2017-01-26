<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace UUid\Form;

use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

class PurgeForm extends Form
{

    /**
     * @param int $id
     */
    function __construct($id)
    {
        parent::__construct('trash');
        $this->setAttribute('method', 'post');

        $this->add(new Csrf('uuid_purge_csrf_' . $id));

        $this->add(
            (new Submit('submit'))->setValue('Purge')->setAttribute('class', 'btn btn-success pull-right')
        );
    }
}
