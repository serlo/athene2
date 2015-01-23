<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Admin\Form;

use Zend\Form\Element\Submit;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class DebuggerForm extends Form {

    function __construct()
    {
        parent::__construct('article');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'clearfix');

        $this->add((new Textarea('message'))->setAttribute('id', 'message')->setAttribute('rows', '50')->setLabel('Message:'));
        $this->add(
            (new Submit('submit'))->setValue('Go')->setAttribute('class', 'btn btn-success pull-right')
        );
    }
}
