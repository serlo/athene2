<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013-2014 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Authorization\Assertion;

use Authorization\Result\AuthorizationResult;
use Instance\Entity\InstanceInterface;
use Instance\Entity\InstanceProviderInterface;

class RequestInstanceAssertion extends InstanceAssertion
{
    /**
     * Check if this assertion is true
     *
     * @param  AuthorizationResult $authorization
     * @param  mixed               $context
     * @return bool
     */
    public function assert(AuthorizationResult $authorization, $context = null)
    {
        if ($context instanceof InstanceProviderInterface or $context instanceof InstanceInterface) {
            $instance = $context;
        } else {
            $instance = $this->instanceManager->getInstanceFromRequest();
        }

        return parent::assert($authorization, $instance);
    }
}
