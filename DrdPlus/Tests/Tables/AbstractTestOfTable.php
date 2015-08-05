<?php
namespace DrdPlus\Tests\Tables;

abstract class AbstractTestOfTable extends TestWithMockery
{

    public function I_can_add_value_in_same_unit()
    {
        
    }
    /**
     * @test
     */
    abstract public function I_can_add_value_in_different_unit();
}
