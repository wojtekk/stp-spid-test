<?php
class FakeTest extends PHPUnit_Framework_TestCase
{
    public function testFake()
    {
        $stack = array();
        $this->assertEquals(0, count($stack));
    }
}