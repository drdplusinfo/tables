<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Measurements\Tools;

use DrdPlus\DiceRolls\Roll;
use DrdPlus\DiceRolls\Templates\Rollers\Roller1d6;
use DrdPlus\Tables\Measurements\Tools\DiceChanceEvaluator;
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
            ->andReturn($this->createRoll(321));
        self::assertSame(0, $evaluator->evaluate(320), 'Higher roll than maximum should result into zero');
        self::assertSame(1, $evaluator->evaluate(321));
        self::assertSame(1, $evaluator->evaluate(322));
    }

    private function createRoll($value)
    {
        $number = $this->mockery(Roll::class);
        $number->shouldReceive('getValue')
            ->andReturn($value);

        return $number;
    }
}