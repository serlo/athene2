<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 07.01.2019
 * Time: 17:14
 */

namespace Mailman\Entity;

interface MailInterface
{
    public function getSubject();
    public function getHtmlBody();
    public function getPlainBody();
}
