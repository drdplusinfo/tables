<?php
namespace DrdPlus\Tests\Tables\Measurements\Tools;

use Drd\DiceRoll\Templates\Rollers\Roller1d6;
use DrdPlus\Tables\Measurements\Tools\DiceChanceEvaluator;
use Granam\Integer\IntegerObject;
use Granam\Tests\Tools\TestWithMockery;

class DiceChanceEvaluatorTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_evaluate_chance_by_dice_roll()
    {
        /** @var \Mockery\MockInterface|Roller1d6 $roller */
        $roller = $this->mockery(Roller1d6::class);
        $evaluator = new DiceChanceEvaluator($roller);
        $roller->shouldReceive('roll')
            ->twice()
            ->andReturnValues([$this->createNumber($higherRoll = 321), $this->createNumber($lowerRoll = 123)]);
        $this->assertSame(1, $evaluator->evaluate($higherRoll - 1));
        $this->assertSame(0, $evaluator->evaluate($lowerRoll + 1));
    }

    private function createNumber($value)
    {
        $number = $this->mockery(IntegerObject::class);
        $number->shouldReceive('getValue')
            ->andReturn($value);

        return $number;
    }
}
