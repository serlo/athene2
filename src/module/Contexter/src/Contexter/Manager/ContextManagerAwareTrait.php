<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Contexter\Manager;

trait ContextManagerAwareTrait
{

    /**
     * @var ContextManagerInterface
     */
    protected $contextManager;

    /**
     * @return ContextManagerInterface $contexter
     */
    public function getContextManager()
    {
        return $this->contextManager;
    }

    /**
     * @param ContextManagerInterface $contexter
     * @return self
     */
    public function setContextManager(ContextManagerInterface $contextManager)
    {
        $this->contextManager = $contextManager;

        return $this;
    }
}
