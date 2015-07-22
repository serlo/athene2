<?php
/**
 * @author Bram Gerritsen bgerritsen@gmail.com
 * @copyright (c) Bram Gerritsen 2013
 * @license http://opensource.org/licenses/mit-license.php
 */

namespace Cache\IdGenerator;

use StrokerCache\Exception\RuntimeException;
use StrokerCache\IdGenerator\IdGeneratorInterface;

class AjaxGenerator implements IdGeneratorInterface
{

    /**
     * {@inheritDoc}
     *
     * @throws RuntimeException
     */
    public function generate()
    {
        if (!isset($_SERVER['REQUEST_URI'])) {
            throw new RuntimeException("Can't auto-detect current page identity");
        }

        $port = ($_SERVER['SERVER_PORT'] == '80') ? '' : (':'.$_SERVER['SERVER_PORT']);
        $scheme = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https' : 'http';
        $ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) : 'notajax';

        return md5($scheme . '://'.$_SERVER['HTTP_HOST']. $port . $_SERVER['REQUEST_URI'] . $ajax);
    }
}
