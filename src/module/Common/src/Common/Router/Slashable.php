<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
