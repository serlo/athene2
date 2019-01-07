<?php
/**
 * Created by PhpStorm.
 * User: Benjamin
 * Date: 07.01.2019
 * Time: 16:48
 */

namespace Mailman\Renderer;

use Mailman\Entity\Mail;

interface MailRendererInterface
{

    /**
     * @param array $data
     * @return Mail
     */
    public function renderMail($data);

    /**
     * @param string $route
     */
    public function setTemplateFolder($route);
}
