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

class OptInFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('subscription');

        $subscribe = new Element\Checkbox('subscribe');
        $subscribe->setName('subscribe');
        $subscribe->setLabel('Add to watchlist.');
        $subscribe->setChecked(true);
        $subscribe->setAttribute('class', 'control');


        $mailman = new Element\Checkbox('mailman');
        $mailman->setName('mailman');
        $mailman->setLabel('Receive notifications via email.');
        $mailman->setChecked(true);
        $mailman->setAttribute('class', 'control');

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
