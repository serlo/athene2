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
namespace Common\Router;

use Zend\Mvc\Router\Http\Segment;

class Slashable extends Segment
{
    public function __construct($route, array $constraints = [], array $defaults = [])
    {
        parent::__construct($route, $constraints, $defaults);

        // add the slash to the allowed unencoded chars map, since this route
        // includes that charater in its 'page' parameter
        if (!isset(static::$urlencodeCorrectionMap['%2F'])) {
            static::$urlencodeCorrectionMap['%2F'] = '/';
        }
    }
}
