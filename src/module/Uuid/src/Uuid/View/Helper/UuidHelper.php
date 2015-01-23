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
namespace Uuid\View\Helper;

use Doctrine\Common\Util\ClassUtils;
use Uuid\Entity\UuidInterface;
use Uuid\Options\ModuleOptions;
use Zend\View\Helper\AbstractHelper;

class UuidHelper extends AbstractHelper
{
    /**
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @param ModuleOptions $moduleOptions
     */
    public function __construct(ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    public function getPermission(UuidInterface $object, $action)
    {
        $class = ClassUtils::getClass($object);
        return $this->moduleOptions->getPermission($class, $action);
    }
}
