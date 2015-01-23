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

namespace Session\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SaveHandler\SaveHandlerInterface;

class SessionController extends AbstractActionController
{
    /**
     * @var SessionConfig
     */
    protected $config;

    /**
     * @var SaveHandlerInterface
     */
    protected $saveHandler;

    public function __construct(SaveHandlerInterface $saveHandler, SessionConfig $config)
    {
        $this->saveHandler = $saveHandler;
        $this->config      = $config;
    }

    public function gcAction()
    {
        $lifetime = $this->config->getRememberMeSeconds();
        $this->saveHandler->gc($lifetime);
        return 'success';
    }
}
