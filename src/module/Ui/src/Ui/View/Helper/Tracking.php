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
namespace Ui\View\Helper;

use Instance\Manager\InstanceManagerInterface;
use Ui\Options\TrackingHelperOptions;
use Zend\View\Helper\AbstractHelper;

class Tracking extends AbstractHelper
{
    /**
     * @var TrackingHelperOptions
     */
    protected $options;

    /**
     * @var InstanceManagerInterface
     */
    protected $instanceManager;

    /**
     * @param InstanceManagerInterface $instanceManager
     * @param TrackingHelperOptions    $options
     */
    public function __construct(InstanceManagerInterface $instanceManager, TrackingHelperOptions $options)
    {
        $this->instanceManager = $instanceManager;
        $instance              = $instanceManager->getInstanceFromRequest();
        $name                  = strtolower($instance->getName());
        $this->options         = $options->getInstance($name);
    }

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->options->getCode();
    }
}
