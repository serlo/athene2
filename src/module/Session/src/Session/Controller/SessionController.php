<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
