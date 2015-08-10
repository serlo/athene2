<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Common\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\Redirect;

class RedirectHelper extends Redirect
{
    public function toReferer($default = '/')
    {
        $referer = $this->getController()->getRequest()->getHeader('Referer');
        $referer = $referer ? $referer->getUri() : $default;

        return $this->toUrl($referer);
    }
}
