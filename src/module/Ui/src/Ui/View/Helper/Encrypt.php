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

namespace Ui\View\Helper;


use Zend\View\Helper\AbstractHelper;

class Encrypt extends AbstractHelper
{
    protected $key = 'iuLG8vrTq48aoK7G';

    public function __invoke($string)
    {
        return base64_encode(
            mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->key), $string, MCRYPT_MODE_CBC, md5(md5($this->key)))
        );
    }

    public function decrypt($encrypted)
    {
        return rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_256,
                md5($this->key),
                base64_decode($encrypted),
                MCRYPT_MODE_CBC,
                md5(md5($this->key))
            ),
            "\0"
        );
    }
}
