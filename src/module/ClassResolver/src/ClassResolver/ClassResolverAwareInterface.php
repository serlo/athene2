<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace ClassResolver;

interface ClassResolverAwareInterface
{

    /**
     * @return self
     */
    public function getClassResolver();

    /**
     * @param ClassResolverInterface $classResolver
     * @return self
     */
    public function setClassResolver(ClassResolverInterface $classResolver);
}
