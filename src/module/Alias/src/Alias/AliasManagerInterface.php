<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Alias;

use Alias\Entity\AliasInterface;
use Common\ObjectManager\Flushable;
use Instance\Entity\InstanceInterface;
use Uuid\Entity\UuidInterface;

interface AliasManagerInterface extends Flushable
{
    /**
     * @param                   $name
     * @param                   $source
     * @param UuidInterface     $object
     * @param InstanceInterface $instance
     * @return void
     */
    public function autoAlias($name, $source, UuidInterface $object, InstanceInterface $instance);

    /**
     * @param                   $source
     * @param                   $alias
     * @param                   $aliasFallback
     * @param UuidInterface     $object
     * @param InstanceInterface $instance
     * @return AliasInterface
     */
    public function createAlias($source, $alias, $aliasFallback, UuidInterface $object, InstanceInterface $instance);

    /**
     * @param UuidInterface $uuid
     * @return AliasInterface
     */
    public function findAliasByObject(UuidInterface $uuid);

    /**
     * @param string            $source
     * @param InstanceInterface $instance
     * @return string
     */
    public function findAliasBySource($source, InstanceInterface $instance);

    /**
     * @param                   $alias
     * @param InstanceInterface $instance
     * @return mixed
     */
    public function findCanonicalAlias($alias, InstanceInterface $instance);

    /**
     * @param string $alias
     * @param bool   $useCache
     * @return string
     */
    public function findSourceByAlias($alias, $useCache = false);
}
