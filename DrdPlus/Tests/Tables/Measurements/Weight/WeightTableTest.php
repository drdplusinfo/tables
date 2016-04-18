<?php
namespace DrdPlus\Tests\Tables\Measurements\Weight;

use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightBonus;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use DrdPlus\Tests\Tables\Measurements\MeasurementTableTest;
use Granam\Tests\Tools\TestWithMockery;

class WeightTableTest extends TestWithMockery implements MeasurementTableTest
{

    /**
     * @test
     */
    public function I_can_get_headers()
    {
        $weightTable = new WeightTable();
        self::assertSame([['bonus', 'kg']], $weightTable->getHeader());
    }

    /**
     * @test
     */
    public function I_can_convert_bonus_to_value()
    {
        $weightTable = new WeightTable();
        self::assertSame(
            0.1,
            $weightTable->toWeight(new WeightBonus(-40, $weightTable))->getValue()
        );
        self::assertSame(
            10.0,
            $weightTable->toWeight(new WeightBonus(0, $weightTable))->getValue()
        );
        self::assertSame(
            9000.0,
            $weightTable->toWeight(new WeightBonus(59, $weightTable))->getValue()
        );
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_use_too_low_bonus_to_value()
    {
        $weightTable = new WeightTable();
        $weightTable->toWeight(new WeightBonus(-41, $weightTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_convert_too_high_bonus_to_value()
    {
        $weightTable = new WeightTable();
        $weightTable->toWeight(new WeightBonus(60, $weightTable));
    }

    /**
     * @test
     */
    public function I_can_convert_value_to_bonus()
    {
        $weightTable = new WeightTable();
        self::assertSame(-40, $weightTable->toBonus(new Weight(0.1, Weight::KG, $weightTable))->getValue());

        self::assertSame(0, $weightTable->toBonus(new Weight(10, Weight::KG, $weightTable))->getValue());

        self::assertSame(20, $weightTable->toBonus(new Weight(104, Weight::KG, $weightTable))->getValue()); // 20 is the closest bonus
        self::assertSame(21, $weightTable->toBonus(new Weight(105, Weight::KG, $weightTable))->getValue()); // 20 and 21 are closest bonuses, 21 is taken because higher
        self::assertSame(21, $weightTable->toBonus(new Weight(106, Weight::KG, $weightTable))->getValue()); // 21 is the closest bonus (higher in this case)

        self::assertSame(59, $weightTable->toBonus(new Weight(9000, Weight::KG, $weightTable))->getValue());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_convert_too_low_value_to_bonus()
    {
        $weightTable = new WeightTable();
        $weightTable->toBonus(new Weight(0.09, Weight::KG, $weightTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_convert_too_high_value_to_bonus()
    {
        $weightTable = new WeightTable();
        $weightTable->toBonus(new Weight(9001, Weight::KG, $weightTable))->getValue();
    }

    /**
     * @test
     */
    public function I_can_convert_simplified_weight_bonus_to_bonus()
    {
        $weightTable = new WeightTable();
        $bonus = $weightTable->simplifiedBonusToBonus($value = 123);
        self::assertSame($value + 12, $bonus->getValue());
    }
}
