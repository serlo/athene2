<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Benjamin Knorr (benjamin@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */


namespace Common\Validator;

use Zend\Validator\Csrf;

class CsrfValidator extends Csrf
{
    /**
     * {@inheritDoc}
     */
    protected function generateHash()
    {
        $this->hash = md5(session_id());

        $this->setValue($this->hash);
        $this->initCsrfToken();
    }

    /**
     * {@inheritdoc}
     */
    protected function initCsrfToken()
    {
        $session = $this->getSession();
        $hash = $this->getHash();
        $session->hash = $hash;
    }

    /**
     * {@inheritdoc}
     */
    protected function getValidationToken($tokenId = null)
    {
        $session = $this->getSession();
        return $session->hash;
    }
}
