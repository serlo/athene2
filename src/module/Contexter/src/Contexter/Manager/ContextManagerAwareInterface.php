<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Contexter\Manager;

interface ContextManagerAwareInterface
{

    /**
     * @return ContextManagerInterface $contexter
     */
    public function getContextManager();

    /**
     * @param ContextManagerInterface $contexter
     * @return self
     */
    public function setContextManager(ContextManagerInterface $contextManager);
}
