<?php
/**
 * Athene2 - Advanced Learning Resources Manager
 *
 * @author         Aeneas Rekkas (aeneas.rekkas@serlo.org)
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @link           https://github.com/serlo-org/athene2 for the canonical source repository
 * @copyright      Copyright (c) 2013 Gesellschaft für freie Bildung e.V. (http://www.open-education.eu/)
 */
namespace ClassResolverTest;

use ClassResolverTest\Fake\ClassResolverAware;

class ClassResolverAwareTraitTest extends \PHPUnit_Framework_TestCase
{
    protected $trait;

    public function setUp()
    {
        $this->trait = new ClassResolverAware();
    }

    public function testSetGet()
    {
        $mock = $this->getMock('ClassResolver\ClassResolver');
        $this->trait->setClassResolver($mock);
        $this->assertSame($mock, $this->trait->getClassResolver());
    }
}
