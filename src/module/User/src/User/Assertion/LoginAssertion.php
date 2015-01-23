<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author       Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license      LGPL-3.0
 * @license      http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link         https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright    Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/]
 */
namespace User\Assertion;

use User\Entity\UserInterface;
use User\Exception\InvalidArgumentException;
use ZfcRbac\Assertion\AssertionInterface;
use ZfcRbac\Service\AuthorizationService;

class LoginAssertion implements AssertionInterface
{
    /**
     * Check if this assertion is true
     *
     * @param  AuthorizationService $authorization
     * @param  mixed                $context
     * @return bool
     */
    public function assert(AuthorizationService $authorization, $context = null)
    {
        if (!$context instanceof UserInterface) {
            throw new InvalidArgumentException();
        }

        return $context->getTrashed() == false;
    }
}
