<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ads\Form;

use Zend\InputFilter\InputFilter;

class AdFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(
            [
                'name'       => 'title',
                'required'   => true,
                'filters'    => [
                    [
                        'name' => 'StripTags',
                        'options' => [
                            'allowTags' => 'a',
                            'allowAttribs' => 'href'
                        ]
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'NotEmpty'
                    ]
                ]
            ]
        );

        $this->add(
            [
                'name'       => 'content',
                'required'   => true,
                'filters'    => [
                    [
                        'name' => 'StripTags',
                        'options' => [
                            'allowTags' => ['br','a'],
                            'allowAttribs' => ['href']
                        ]
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'NotEmpty'
                    ]
                ]
            ]
        );
    }
}
