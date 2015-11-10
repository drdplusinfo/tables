<?php
namespace DrdPlus\Tests\Tables\Measurements;

class TestWithMockery extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        \Mockery::close();
    }

    protected function mockery($class)
    {
        return \Mockery::mock($class);
    }
}
