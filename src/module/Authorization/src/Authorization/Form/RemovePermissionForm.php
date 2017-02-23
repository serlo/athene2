<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author       Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link         https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright    Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace Authorization\Form;

use Zend\Form\Element\Submit;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class RemovePermissionForm extends Form
{
    function __construct($roleID, $permissionID)
    {
        parent::__construct('trash');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'pull-right');

        $this->add(new Csrf('authorization_remove_permission_csrf_' . $roleID . '_' . $permissionID));
        $this->add((new Hidden('role'))->setValue($roleID));
        $this->add((new Hidden('permission'))->setValue($permissionID));
        $this->add(
            (new Submit('submit'))->setValue('Remove')->setAttribute('class', 'btn btn-success pull-right')
        );
    }
}