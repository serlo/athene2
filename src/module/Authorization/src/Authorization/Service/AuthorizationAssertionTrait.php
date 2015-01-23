<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license        LGPL-3.0
 * @license        http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Authorization\Service;

use ZfcRbac\Exception\UnauthorizedException;
use ZfcRbac\Service\AuthorizationServiceAwareTrait;

trait AuthorizationAssertionTrait
{
    use AuthorizationServiceAwareTrait;

    /**
     * Assert that access is granted
     *
     * @param string $permission
     * @param mixed  $context
     * @throws UnauthorizedException
     * @return void
     */
    protected function assertGranted($permission, $context = null)
    {
        if (!$this->getAuthorizationService()->isGranted($permission, $context)) {
            throw new UnauthorizedException(sprintf('Permission %s was not granted.', $permission));
        }
    }
}
