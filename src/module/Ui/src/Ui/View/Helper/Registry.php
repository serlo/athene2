<?php
/**
 * 
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author	Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license	LGPL-3.0
 * @license	http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link		https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Ui\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Registry extends AbstractHelper
{

    protected $registry = [];

    public function __invoke()
    {
        return $this;
    }

    public function add($key, $value)
    {
        if(!array_key_exists($key, $this->registry)){
            $this->registry[$key] = [];
        }
        $this->registry[$key][] = $value;
        return $this;
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->registry)) {
            $return = '';
            foreach($this->registry[$key] as $value){
                $return .= $value;
            }
            return $return;
        } else {
            return NULL;
        }
    }
}
