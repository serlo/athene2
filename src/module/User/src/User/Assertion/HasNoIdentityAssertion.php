<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author       Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link         https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright    Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace User\Assertion;

use ZfcRbac\Assertion\AssertionInterface;
use ZfcRbac\Service\AuthorizationService;

class HasNoIdentityAssertion implements AssertionInterface
{
    /**
     * Check if this assertion is true
     *
     * @param  AuthorizationService $authorization
     * @return bool
     */
    public function assert(AuthorizationService $authorization)
    {
        return !is_object($authorization->getIdentity());
    }
}
