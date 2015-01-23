<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author       Jakob Pfab (jakob.pfab@serlo.org)
 * @author       Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license      LGPL-3.0
 * @license      http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link         https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright    Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Authorization\Guard;

use Zend\Mvc\MvcEvent;
use ZfcRbac\Guard\ControllerGuard;

/**
 * A hydratable controller guard can protect a controller and a set of actions
 * and hydrate the roles with a
 */
class HydratableControllerGuard extends ControllerGuard
{

    use\Zend\ServiceManager\ServiceLocatorAwareTrait;

    /**
     * {@inheritDoc}
     */
    public function setRules(array $rules)
    {
        $this->rules = [];

        foreach ($rules as $rule) {

            $controller = strtolower($rule['controller']);
            $actions    = isset($rule['actions']) ? (array)$rule['actions'] : [];

            if (empty($actions)) {
                $this->rules[$controller][0] = $rule['role_provider'];
                continue;
            }

            foreach ($actions as $action) {
                $this->rules[$controller][strtolower($action)] = $rule['role_provider'];
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function isGranted(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch();
        $controller = strtolower($routeMatch->getParam('controller'));
        $action     = strtolower($routeMatch->getParam('action'));

        // If no rules apply, it is considered as granted or not based on the protection policy
        if (!isset($this->rules[$controller])) {
            return $this->protectionPolicy === self::POLICY_ALLOW;
        }

        // Algorithm is as follow: we first check if there is an exact match (controller + action), if not
        // we check if there are rules set globally for the whole controllers (see the index "0"), and finally
        // if nothing is matched, we fallback to the protection policy logic

        if (isset($this->rules[$controller][$action])) {
            $providerName = $this->rules[$controller][$action];
        } elseif (isset($this->rules[$controller][0])) {
            $providerName = $this->rules[$controller][0];
        } else {
            return $this->protectionPolicy === self::POLICY_ALLOW;
        }

        $provider = new $providerName($event);
        $provider->setServiceLocator($this->getServiceLocator());
        $allowedRoles = $provider->getRoles();

        if (in_array('*', $allowedRoles)) {
            return true;
        }

        return $this->roleService->matchIdentityRoles($allowedRoles);
    }
}
