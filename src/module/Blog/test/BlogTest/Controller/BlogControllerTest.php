<?php

use AtheneTest\TestCase\AbstractControllerTest;

function t($string)
{
    echo "juhu";
    return $string;
}

class BlogControllerTest extends AbstractControllerTest
{
    protected $traceError = true;

    public function setUp()
    {
        parent::setUp();
    }

    public function testIndexAction()
    {
        $this->dispatch("/blog");
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('blog');
        //$this->assertControllerName('BlogController');
        $this->assertControllerClass('BlogController');
        $this->assertMatchedRouteName('blog');
    }
}
