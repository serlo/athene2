<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Benjamin Knorr (benjamin@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Common\Form\Element;

use Zend\Form\Element\Csrf;
use Common\Validator\CsrfValidator;

class CsrfToken extends Csrf
{
    /**
     * {@inheritDoc}
     */
    public function getCsrfValidator()
    {
        if (null === $this->csrfValidator) {
            $csrfOptions = $this->getCsrfValidatorOptions();
            $csrfOptions = array_merge($csrfOptions, array('name' => $this->getName()));
            $this->setCsrfValidator(new CsrfValidator($csrfOptions));
        }
        return $this->csrfValidator;
    }
}
