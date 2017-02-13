<?php
namespace DrdPlus\Tests\Tables\Measurements\Tools;

use Drd\DiceRolls\Templates\Rollers\Roller1d6;
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
            ->andReturn($this->createNumber(321));
        self::assertSame(0, $evaluator->evaluate(320), 'Higher roll than maximum should result into zero');
        self::assertSame(1, $evaluator->evaluate(321));
        self::assertSame(1, $evaluator->evaluate(322));
    }

    private function createNumber($value)
    {
        $number = $this->mockery(IntegerObject::class);
        $number->shouldReceive('getValue')
            ->andReturn($value);

        return $number;
    }
}