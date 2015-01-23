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
namespace Authentication\Service;

use Zend\Authentication\Adapter;
use Zend\Authentication\AuthenticationService as ZendAuthenticationService;
use Zend\Authentication\Exception;
use Zend\Authentication\Storage;
use Zend\Http\Header\SetCookie;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Session\Config\SessionConfig;
use Zend\Stdlib\RequestInterface;
use Zend\Stdlib\ResponseInterface;

class AuthenticationService extends ZendAuthenticationService
{

    /**
     * @var SessionConfig
     */
    protected $sessionConfig;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $cookieName = 'authenticated';

    /**
     * @var string
     */
    protected $cookiePath = '/';

    public function __construct(
        Storage\StorageInterface $storage = null,
        Adapter\AdapterInterface $adapter = null,
        SessionConfig $sessionConfig,
        ResponseInterface $response,
        RequestInterface $request
    ) {
        parent::__construct($storage, $adapter);

        if (!$response instanceof Response) {
            $response = new Response;
        }

        if (!$request instanceof Request) {
            $request = new Request;
        }

        $this->response      = $response;
        $this->request       = $request;
        $this->sessionConfig = $sessionConfig;
    }

    public function authenticate(Adapter\AdapterInterface $adapter = null)
    {
        $result = parent::authenticate($adapter);

        if ($result->isValid()) {
            // Set authentication indicator cookie
            $lifetime = (int)$this->sessionConfig->getCookieLifetime();
            $expires  = $lifetime !== 0 ? time() + $lifetime : null;
            $lifetime = $lifetime !== 0 ? $lifetime : null;
            $this->setCookie(true, $expires, $lifetime);
        }

        return $result;
    }

    public function clearIdentity()
    {
        parent::clearIdentity();

        // Remove authentication indicator cookie
        $expires = time() - 3600;
        $this->setCookie('', $expires);
    }

    public function getIdentity()
    {
        $return = parent::getIdentity();
        if ($return !== null && !$this->hasIndicator()) {
            $this->clearIdentity();
            return null;
        }
        return $return;
    }

    public function hasIdentity()
    {
        $return = parent::hasIdentity();
        if ($return && !$this->hasIndicator()) {
            $this->clearIdentity();
            return false;
        }
        return $return;
    }

    protected function hasIndicator()
    {
        $cookie = $this->request->getCookie();
        if ($cookie->offsetExists($this->cookieName) && $cookie->offsetGet($this->cookieName)) {
            return true;
        }
        $cookies = $this->response->getCookie();
        foreach ($cookies as $cookie) {
            if ($cookie->getName() === $this->cookieName && $cookie->getValue() === true) {
                return true;
            }
        }
        return false;
    }

    protected function setCookie($value, $expires = null, $lifetime = null)
    {
        $cookie = new SetCookie(
            (string)$this->cookieName, $value, $expires, $this->cookiePath, null, null, null, $lifetime, null
        );
        $this->response->getHeaders()->addHeader($cookie);
    }
}
