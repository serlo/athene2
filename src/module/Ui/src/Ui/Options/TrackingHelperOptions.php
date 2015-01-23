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
namespace Ui\Options;

use Zend\Stdlib\AbstractOptions;

class TrackingHelperOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $instances = [];

    /**
     * @var TrackingHelperInstanceOptions[]
     */
    protected $options = [];

    /**
     * @param $name
     * @return TrackingHelperInstanceOptions
     */
    public function getInstance($name)
    {
        if (!isset($this->instances[$name])) {
            $this->instances[$name] = [];
        }

        if (!is_object($this->instances[$name])) {
            $options                = $this->instances[$name];
            $this->instances[$name] = new TrackingHelperInstanceOptions($options);
        }

        return $this->instances[$name];
    }

    /**
     * @return array
     */
    public function getInstances()
    {
        return $this->instances;
    }

    /**
     * @param array $instances
     */
    public function setInstances(array $instances)
    {
        $this->instances = $instances;
    }
}
