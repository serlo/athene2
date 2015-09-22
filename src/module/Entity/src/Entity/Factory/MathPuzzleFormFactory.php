<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author    Jonas Keinholz (jonas@keinholz.com)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link      https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */

namespace Entity\Factory;

class MathPuzzleFormFactory extends AbstractFormFactory
{
    protected function getClassName()
    {
        return 'Entity\Form\MathPuzzleForm';
    }
}
