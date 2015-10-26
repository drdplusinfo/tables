<?php
namespace DrdPlus\Tests\Tables\Measurements\Tools;

use Drd\DiceRoll\Templates\Rolls\Roll1d6;
use DrdPlus\Tables\Measurements\Tools\DiceChanceEvaluator;
use DrdPlus\Tools\Tests\TestWithMockery;

class DiceChanceEvaluatorTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_evaluate_chance_by_dice_roll()
    {
        /** @var \Mockery\MockInterface|Roll1d6 $roll */
        $roll = $this->mockery(Roll1d6::class);
        $evaluator = new DiceChanceEvaluator($roll);
        $roll->shouldReceive('roll')
            ->twice()
            ->andReturnValues([$higherRoll = 321, $lowerRoll = 123]);
        $this->assertSame(1, $evaluator->evaluate($higherRoll - 1));
        $this->assertSame(0, $evaluator->evaluate($lowerRoll + 1));
    }
}
