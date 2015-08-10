<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace ClassResolver;

trait ClassResolverAwareTrait
{

    /**
     * @var ClassResolverInterface
     */
    protected $classResolver;

    /**
     * @return ClassResolverInterface $classResolver
     */
    public function getClassResolver()
    {
        return $this->classResolver;
    }

    /**
     * @param ClassResolverInterface $classResolver
     * @return self
     */
    public function setClassResolver(ClassResolverInterface $classResolver)
    {
        $this->classResolver = $classResolver;

        return $this;
    }
}
