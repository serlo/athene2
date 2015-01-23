<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   LGPL-3.0
 * @license   http://opensource.org/licenses/LGPL-3.0 The GNU Lesser General Public License, version 3.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */

namespace Navigation\Controller;


use Alias\AliasManagerInterface;
use Alias\Exception\AliasNotFoundException;
use Taxonomy\Controller\AbstractController;
use Zend\Http\Request;
use Zend\Mvc\Router\RouteMatch;
use Zend\View\Model\ViewModel;

class RenderController extends AbstractController
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var AliasManagerInterface
     */
    protected $aliasManager;

    /**
     * @param array                 $config
     * @param AliasManagerInterface $aliasManager
     */
    public function __construct(array $config, AliasManagerInterface $aliasManager)
    {
        $this->config       = $config;
        $this->aliasManager = $aliasManager;
    }

    public function jsonAction()
    {
        $response = $this->getResponse();
        $headers  = $response->getHeaders();
        $headers->addHeaders(['Content-Type' => 'application/json']);
        return $this->process('navigation/render/json');
    }

    public function listAction()
    {
        return $this->process('navigation/render/list');
    }

    protected function isValidNavigationKey($key)
    {
        // TODO: Wow, that's haxxyy - this is due to the fucked up name conventions in the navigations.
        $key = str_replace('_navigation', '', $key);
        $key = str_replace('-', '_', $key);
        return array_key_exists($key, $this->config);
    }

    /**
     * @param $template
     * @return bool|ViewModel
     */
    protected function process($template)
    {
        $navigation = $this->params('navigation');
        $current    = $this->params('current');
        $depth      = $this->params('depth');
        $branch     = $this->params('branch');

        if (!$this->isValidNavigationKey($navigation)) {
            $this->getResponse()->setStatusCode(404);
            return false;
        }

        $view = new ViewModel([
            'container'                 => $navigation,
            'current'                   => $current,
            'depth'                     => $depth,
            'branch'                    => $branch,
            '__disableTemplateDebugger' => true
        ]);

        $view->setTemplate($template);
        $view->setTerminal(true);

        return $view;
    }
}
