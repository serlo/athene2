<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 18.06.18
 * Time: 10:09
 */

namespace Entity\Factory;


class AppletFormFactory extends AbstractFormFactory
{
    protected function getClassName()
    {
        return 'Entity\Form\AppletForm';
    }
}
