<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\DummyEvaluator;

class DummyEvaluatorTest extends TestWithMockery
{

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnsupportedMethodCalled
     */
    public function I_can_not_use_it_for_evaluation()
    {
        $evaluator = new DummyEvaluator();
        $evaluator->evaluate(123);
    }
}
