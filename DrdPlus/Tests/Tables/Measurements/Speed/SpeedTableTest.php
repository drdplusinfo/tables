<?php
namespace DrdPlus\Tests\Tables\Measurements\Speed;

use DrdPlus\Tables\Measurements\Speed\Speed;
use DrdPlus\Tables\Measurements\Speed\SpeedBonus;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tests\Tables\Measurements\MeasurementTableTest;

class SpeedTableTest extends MeasurementTableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $speedTable = new SpeedTable();

        self::assertEquals([['bonus', 'm/round', 'km/h']], $speedTable->getHeader());
    }

    /**
     * @test
     */
    public function I_can_convert_bonus_to_value()
    {
        $speedTable = new SpeedTable();
        self::assertSame(0.1, $speedTable->toSpeed(new SpeedBonus(-20, $speedTable))->getMetersPerRound());

        self::assertSame(1.0, $speedTable->toSpeed(new SpeedBonus(0, $speedTable))->getMetersPerRound());
        self::assertSame(0.36, $speedTable->toSpeed(new SpeedBonus(0, $speedTable))->getKilometersPerHour());

        self::assertSame(
            number_format(3.2, 5),
            number_format($speedTable->toSpeed(new SpeedBonus(10, $speedTable))->getMetersPerRound(), 5)
        );

        self::assertSame(900.0, $speedTable->toSpeed(new SpeedBonus(59, $speedTable))->getMetersPerRound());
        self::assertSame(320.0, $speedTable->toSpeed(new SpeedBonus(59, $speedTable))->getKilometersPerHour());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_use_too_low_bonus_to_value()
    {
        $speedTable = new SpeedTable();
        $speedTable->toSpeed(new SpeedBonus(-21, $speedTable))->getMetersPerRound();
    }

    /**
     * @test
     */
    public function I_can_convert_value_to_bonus()
    {
        $speedTable = new SpeedTable();
        self::assertSame(-20, $speedTable->toBonus(new Speed(0.1, Speed::M_PER_ROUND, $speedTable))->getValue());

        self::assertSame(0, $speedTable->toBonus(new Speed(1, Speed::M_PER_ROUND, $speedTable))->getValue());

        self::assertSame(40, $speedTable->toBonus(new Speed(104, Speed::M_PER_ROUND, $speedTable))->getValue()); // 40 is the closest bonus
        self::assertSame(41, $speedTable->toBonus(new Speed(105, Speed::M_PER_ROUND, $speedTable))->getValue()); // 40 and 41 are closest bonuses, 41 is taken because higher
        self::assertSame(41, $speedTable->toBonus(new Speed(106, Speed::M_PER_ROUND, $speedTable))->getValue()); // 41 is the closest bonus (higher in this case)

        self::assertSame(40, $speedTable->toBonus(new Speed(37, Speed::KM_PER_HOUR, $speedTable))->getValue()); // 40 is the closest bonus
        self::assertSame(41, $speedTable->toBonus(new Speed(38, Speed::KM_PER_HOUR, $speedTable))->getValue()); // 40 and 41 are closest bonuses, 41 is taken because higher
        self::assertSame(41, $speedTable->toBonus(new Speed(38, Speed::KM_PER_HOUR, $speedTable))->getValue()); // 41 is the closest bonus (higher in this case)

        self::assertSame(59, $speedTable->toBonus(new Speed(900, Speed::M_PER_ROUND, $speedTable))->getValue());

        self::assertSame(99, $speedTable->toBonus(new Speed(32000, Speed::KM_PER_HOUR, $speedTable))->getValue());
        self::assertSame(99, $speedTable->toBonus(new Speed(32000, Speed::KM_PER_HOUR, $speedTable))->getValue());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_convert_too_high_bonus_to_too_detailed_unit()
    {
        $speedTable = new SpeedTable();
        $speedTable->toSpeed(new SpeedBonus(100, $speedTable))->getMetersPerRound();
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_convert_too_low_value_to_bonus()
    {
        $speedTable = new SpeedTable();
        $speedTable->toBonus(new Speed(0.09, Speed::M_PER_ROUND, $speedTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_convert_too_high_value_to_bonus()
    {
        $speedTable = new SpeedTable();
        $speedTable->toBonus(new Speed(32001, Speed::KM_PER_HOUR, $speedTable));
    }
}
