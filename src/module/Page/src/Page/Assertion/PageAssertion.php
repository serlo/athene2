<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 */

namespace Page\Assertion;

use Authorization\Assertion\AssertionInterface;
use Authorization\Result\AuthorizationResult;
use Page\Entity\PageRepositoryInterface;
use Page\Entity\PageRevisionInterface;
use Page\Exception\InvalidArgumentException;
use Rbac\Traversal\Strategy\TraversalStrategyInterface;

class PageAssertion implements AssertionInterface
{


    /**
     * @var TraversalStrategyInterface
     */
    protected $traversalStrategy;

    /**
     * @param TraversalStrategyInterface $traversalStrategy
     */
    public function __construct(TraversalStrategyInterface $traversalStrategy)
    {
        $this->traversalStrategy = $traversalStrategy;
    }

    /**
     * Check if this assertion is true
     *
     * @param  AuthorizationResult $authorization
     * @param  mixed               $context
     * @return bool
     * @throws InvalidArgumentException
     */
    public function assert(AuthorizationResult $authorization, $context = null)
    {
        if ($context instanceof PageRepositoryInterface) {
        } elseif ($context instanceof PageRevisionInterface) {
            $context = $context->getRepository();
        } else {
            throw new InvalidArgumentException;
        }

        $flattened = $this->flattenRoles($authorization->getRoles());

        foreach ($context->getRoles() as $role) {
            if (in_array($role, $flattened)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $roles
     * @return array
     */
    protected function flattenRoles(array $roles)
    {
        $roleNames = [];
        $iterator  = $this->traversalStrategy->getRolesIterator($roles);

        foreach ($iterator as $role) {
            $roleNames[] = $role;
        }

        return array_unique($roleNames);
    }
}
