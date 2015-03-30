<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author      Jonas Keinholz (jonas.keinholz@serlo.org)
 * @license     MIT License
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link        https://github.com/serlo-org/athene2 for the canonical source repository
 */
namespace Navigation\Factory;

class SocialNavigationFactory extends ProvideableNavigationFactory
{
    protected function getName()
    {
        return 'social';
    }
}
