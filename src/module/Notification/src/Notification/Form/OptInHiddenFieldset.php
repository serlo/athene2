<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Notification\Form;

use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class OptInHiddenFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('subscription');

        $subscribe = new Element\Hidden('subscribe');
        $subscribe->setName('subscribe');
        $subscribe->setValue(true);

        $mailman = new Element\Hidden('mailman');
        $mailman->setName('mailman');
        $mailman->setValue(true);

        $this->add($subscribe);
        $this->add($mailman);
    }

    public function getInputFilterSpecification()
    {
        return [
            [
                'name'     => 'subscribe',
                'required' => true,
            ],
            [
                'name'     => 'mailman',
                'required' => true,
            ],
        ];
    }
}
