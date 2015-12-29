<?php
namespace DrdPlus\Tests\Tables\Measurements\Speed;

use DrdPlus\Tables\Measurements\Speed\Speed;
use DrdPlus\Tables\Measurements\Speed\SpeedBonus;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tools\Tests\TestWithMockery;

class SpeedTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function can_convert_bonus_to_speed()
    {
        $speedTable = new SpeedTable();
        $this->assertSame(0.1, $speedTable->toSpeed(new SpeedBonus(-20, $speedTable))->getMetersPerRound());

        $this->assertSame(1.0, $speedTable->toSpeed(new SpeedBonus(0, $speedTable))->getMetersPerRound());
        $this->assertSame(0.36, $speedTable->toSpeed(new SpeedBonus(0, $speedTable))->getKilometersPerHour());

        $this->assertSame(
            number_format(3.2, 5),
            number_format($speedTable->toSpeed(new SpeedBonus(10, $speedTable))->getMetersPerRound(), 5)
        );

        $this->assertSame(900.0, $speedTable->toSpeed(new SpeedBonus(59, $speedTable))->getMetersPerRound());
        $this->assertSame(320.0, $speedTable->toSpeed(new SpeedBonus(59, $speedTable))->getKilometersPerHour());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_bonus_to_speed_cause_exception()
    {
        $speedTable = new SpeedTable();
        $speedTable->toSpeed(new SpeedBonus(-21, $speedTable))->getMetersPerRound();
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_bonus_to_speed_cause_exception()
    {
        $speedTable = new SpeedTable();
        $speedTable->toSpeed(new SpeedBonus(100, $speedTable))->getMetersPerRound();
    }

    /**
     * @test
     */
    public function can_convert_speed_to_bonus()
    {
        $speedTable = new SpeedTable();
        $this->assertSame(-20, $speedTable->toBonus(new Speed(0.1, Speed::M_PER_ROUND, $speedTable))->getValue());

        $this->assertSame(0, $speedTable->toBonus(new Speed(1, Speed::M_PER_ROUND, $speedTable))->getValue());

        $this->assertSame(40, $speedTable->toBonus(new Speed(104, Speed::M_PER_ROUND, $speedTable))->getValue()); // 40 is the closest bonus
        $this->assertSame(41, $speedTable->toBonus(new Speed(105, Speed::M_PER_ROUND, $speedTable))->getValue()); // 40 and 41 are closest bonuses, 41 is taken because higher
        $this->assertSame(41, $speedTable->toBonus(new Speed(106, Speed::M_PER_ROUND, $speedTable))->getValue()); // 41 is the closest bonus (higher in this case)

        $this->assertSame(40, $speedTable->toBonus(new Speed(37, Speed::KM_PER_HOUR, $speedTable))->getValue()); // 40 is the closest bonus
        $this->assertSame(41, $speedTable->toBonus(new Speed(38, Speed::KM_PER_HOUR, $speedTable))->getValue()); // 40 and 41 are closest bonuses, 41 is taken because higher
        $this->assertSame(41, $speedTable->toBonus(new Speed(38, Speed::KM_PER_HOUR, $speedTable))->getValue()); // 41 is the closest bonus (higher in this case)

        $this->assertSame(59, $speedTable->toBonus(new Speed(900, Speed::M_PER_ROUND, $speedTable))->getValue());

        $this->assertSame(99, $speedTable->toBonus(new Speed(32000, Speed::KM_PER_HOUR, $speedTable))->getValue());
        $this->assertSame(99, $speedTable->toBonus(new Speed(32000, Speed::KM_PER_HOUR, $speedTable))->getValue());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_value_to_bonus_cause_exception()
    {
        $speedTable = new SpeedTable();
        $speedTable->toBonus(new Speed(0.09, Speed::M_PER_ROUND, $speedTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_value_to_bonus_cause_exception()
    {
        $speedTable = new SpeedTable();
        $speedTable->toBonus(new Speed(32001, Speed::KM_PER_HOUR, $speedTable));
    }
}
