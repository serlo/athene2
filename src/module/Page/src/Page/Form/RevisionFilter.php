<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Page\Form;

use Zend\InputFilter\InputFilter;

class RevisionFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(
            [
                'name'     => 'title',
                'required' => true,
            ]
        );

        $this->add(
            [
                'name'     => 'content',
                'required' => true,
            ]
        );
    }
}
