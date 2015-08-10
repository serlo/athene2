<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org]
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c] 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Authorization\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use ZfcRbac\Exception\UnauthorizedException;

class AssertGranted extends AbstractPlugin
{
    /**
     * Assert that access is granted
     *
     * @param string $permission
     * @param mixed  $context
     * @throws UnauthorizedException
     * @return void
     */
    public function __invoke($permission, $context = null)
    {
        if (!$this->getController()->isGranted($permission, $context)) {
            throw new UnauthorizedException();
        }
    }
}
