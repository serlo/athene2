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

use Common\Form\Element\CsrfToken;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

class RemovePermissionForm extends Form
{
    function __construct($roleID, $permissionID)
    {
        parent::__construct('trash');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'pull-right');

        $this->add(new CsrfToken('csrf'));
        $this->add((new Hidden('role'))->setValue($roleID));
        $this->add((new Hidden('permission'))->setValue($permissionID));
        $this->add(
            (new Submit('submit'))->setValue('Remove')->setAttribute('class', 'btn btn-success pull-right')
        );
    }
}