<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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

        $mailman = new Element\Checkbox('mailman');
        $mailman->setName('mailman');
        $mailman->setLabel('Receive notifications via email.');
        $mailman->setChecked(true);

        $this->add($subscribe);
        $this->add($mailman);
    }

    public function getInputFilterSpecification()
    {
        return [
            [
                'name'     => 'subscribe',
                'required' => true
            ],
            [
                'name'     => 'mailman',
                'required' => true
            ]
        ];
    }
}
