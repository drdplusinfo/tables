<?php
namespace DrdPlus\Tests\Tables\Measurements\Tools;

use DrdPlus\Tables\Measurements\Tools\DummyEvaluator;
use DrdPlus\Tests\Tools\TestWithMockery;

class DummyEvaluatorTest extends TestWithMockery
{

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Exceptions\UnsupportedMethodCalled
     */
    public function I_can_not_use_it_for_evaluation()
    {
        $evaluator = new DummyEvaluator();
        $evaluator->evaluate(123);
    }
}
