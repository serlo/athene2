<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Metadata\Listener;

use Common\Listener\AbstractSharedListenerAggregate;
use Metadata\Manager\MetadataManagerAwareTrait;

abstract class AbstractListener extends AbstractSharedListenerAggregate
{
    use MetadataManagerAwareTrait;
}
