<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06.03.2017
 * Time: 11:55
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
        $timeout = $this->getTimeout();
        if (null !== $timeout) {
            $session->setExpirationSeconds($timeout);
        }

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