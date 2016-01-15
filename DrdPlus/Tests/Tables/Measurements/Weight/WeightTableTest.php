<?php
namespace DrdPlus\Tests\Tables\Measurements\Weight;

use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tables\Measurements\Weight\WeightBonus;
use DrdPlus\Tables\Measurements\Weight\WeightTable;
use DrdPlus\Tests\Tools\TestWithMockery;

class WeightTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_get_headers()
    {
        $weightTable = new WeightTable();
        $this->assertSame(['kg'], $weightTable->getColumnsHeader());
        $this->assertSame(['bonus'], $weightTable->getRowsHeader());
    }

    /**
     * @test
     */
    public function I_can_convert_bonus_to_kg()
    {
        $weightTable = new WeightTable();
        $this->assertSame(
            0.1,
            $weightTable->toWeight(new WeightBonus(-40, $weightTable))->getValue()
        );
        $this->assertSame(
            10.0,
            $weightTable->toWeight(new WeightBonus(0, $weightTable))->getValue()
        );
        $this->assertSame(
            9000.0,
            $weightTable->toWeight(new WeightBonus(59, $weightTable))->getValue()
        );
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_bonus_to_kg_cause_exception()
    {
        $weightTable = new WeightTable();
        $weightTable->toWeight(new WeightBonus(-41, $weightTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_bonus_to_kg_cause_exception()
    {
        $weightTable = new WeightTable();
        $weightTable->toWeight(new WeightBonus(60, $weightTable));
    }

    /**
     * @test
     */
    public function can_convert_kg_to_bonus()
    {
        $weightTable = new WeightTable();
        $this->assertSame(-40, $weightTable->toBonus(new Weight(0.1, Weight::KG, $weightTable))->getValue());

        $this->assertSame(0, $weightTable->toBonus(new Weight(10, Weight::KG, $weightTable))->getValue());

        $this->assertSame(20, $weightTable->toBonus(new Weight(104, Weight::KG, $weightTable))->getValue()); // 20 is the closest bonus
        $this->assertSame(21, $weightTable->toBonus(new Weight(105, Weight::KG, $weightTable))->getValue()); // 20 and 21 are closest bonuses, 21 is taken because higher
        $this->assertSame(21, $weightTable->toBonus(new Weight(106, Weight::KG, $weightTable))->getValue()); // 21 is the closest bonus (higher in this case)

        $this->assertSame(59, $weightTable->toBonus(new Weight(9000, Weight::KG, $weightTable))->getValue());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_value_to_bonus_cause_exception()
    {
        $weightTable = new WeightTable();
        $weightTable->toBonus(new Weight(0.09, Weight::KG, $weightTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_value_to_bonus_cause_exception()
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
        $this->assertSame($value + 12, $bonus->getValue());
    }
}
