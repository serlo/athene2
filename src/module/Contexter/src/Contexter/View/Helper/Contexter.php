<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Contexter\View\Helper;

use Zend\View\Helper\AbstractHelper;

class Contexter extends AbstractHelper
{
    use \Contexter\Router\RouterAwareTrait;

    protected $url = false;

    public function __invoke()
    {
        return $this;
    }

    public function forceUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function render($type = null)
    {
        if (is_object($this->getRouter()->getRouteMatch())) {
            $matches   = $this->getRouter()->match(null, $type);
            $url       = $this->url;
            $this->url = false;
            return $this->getView()->partial(
                'contexter/helper/default',
                [
                    'router'  => $this->getRouter(),
                    'matches' => $matches,
                    'type'    => $type,
                    'url'     => $url
                ]
            );
        }
    }

    public function renderButton($float = null, $class = 'btn-primary')
    {
        if (is_object($this->getRouter()->getRouteMatch())) {
            $matches   = $this->getRouter()->match();
            $url       = $this->url;
            $this->url = false;
            return $this->getView()->partial(
                'contexter/helper/button',
                [
                    'router'  => $this->getRouter(),
                    'matches' => $matches,
                    'url'     => $url,
                    'float'   => $float,
                    'class'   => $class,
                ]
            );
        }
    }
}
