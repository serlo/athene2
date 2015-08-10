<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace Markdown\Options;

class ModuleOptions
{

    /**
     * @var string
     */
    protected $port = 7070;

    /**
     * @var string
     */
    protected $host = '127.0.0.1';

    /**
     * @return string $port
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string $host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $port
     * @return self
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @param string $host
     * @return self
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }
}
