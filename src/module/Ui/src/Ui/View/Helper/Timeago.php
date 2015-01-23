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

use DateTime;
use Zend\View\Helper\AbstractHelper;

class Timeago extends AbstractHelper
{
    public function __invoke(){
        return $this;
    }
    
    public function format(\Datetime $datetime){
        return $datetime->format('Y-m-d H:i:s');
    }
    
    public function render(Datetime $datetime){
        return '<abbr class="timeago" title="'.$this->format($datetime).'">'.$this->format($datetime).'</abbr>';
    }
}
