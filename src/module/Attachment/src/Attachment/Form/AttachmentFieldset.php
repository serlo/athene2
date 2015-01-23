<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Attachment\Form;


use Zend\Form\Element\File;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class AttachmentFieldset extends Fieldset implements InputFilterProviderInterface
{
    /**
     * @var bool
     */
    protected $required;

    public function __construct($required = true)
    {
        parent::__construct('attachment');
        $this->add((new File('file'))->setLabel('Attach file:'));
        $this->required = $required;
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return [
            [
                'name'       => 'file',
                'required'   => $this->required,
                'validators' => [
                    [
                        'name'    => 'Zend\Validator\File\Size',
                        'options' => [
                            'max' => '4MB'
                        ],
                    ],
                    [
                        'name'    => 'Zend\Validator\File\Extension',
                        'options' => [
                            'jpg',
                            'jpeg',
                            'png',
                            'pdf',
                            'ggb',
                            'gif',
                            'tif',
                            'tiff',
                            'svg',
                            'xml'
                        ]
                    ],
                ]
            ]
        ];
    }
}
