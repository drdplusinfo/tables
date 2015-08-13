<?php
namespace DrdPlus\Tests\Tables\BonusBased\Speed;

use DrdPlus\Tables\BonusBased\Speed\SpeedMeasurement;
use DrdPlus\Tables\BonusBased\Speed\SpeedTable;
use DrdPlus\Tests\Tables\TestWithMockery;

class SpeedTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function can_convert_bonus_to_speed()
    {
        $speedTable = new SpeedTable();
        $this->assertSame(0.1, $speedTable->toMetersPerRound(-20));

        $this->assertSame(1.0, $speedTable->toMetersPerRound(0));
        $this->assertSame(0.36, $speedTable->toKilometersPerHour(0));

        $this->assertSame(900.0, $speedTable->toMetersPerRound(59));
        $this->assertSame(320.0, $speedTable->toKilometersPerHour(59));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_bonus_to_speed_cause_exception()
    {
        $speedTable = new SpeedTable();
        $speedTable->toMetersPerRound(-21);
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_bonus_to_speed_cause_exception()
    {
        $speedTable = new SpeedTable();
        $speedTable->toMetersPerRound(100);
    }

    /**
     * @test
     */
    public function can_convert_speed_to_bonus()
    {
        $speedTable = new SpeedTable();
        $this->assertSame(-20, $speedTable->toBonus(new SpeedMeasurement(0.1, SpeedMeasurement::M_PER_ROUND)));
        $this->assertSame(-20, $speedTable->mPerRoundToBonus(0.1));

        $this->assertSame(0, $speedTable->toBonus(new SpeedMeasurement(1, SpeedMeasurement::M_PER_ROUND)));
        $this->assertSame(0, $speedTable->mPerRoundToBonus(1));

        $this->assertSame(40, $speedTable->mPerRoundToBonus(104)); // 40 is the closest bonus
        $this->assertSame(41, $speedTable->mPerRoundToBonus(105)); // 40 and 41 are closest bonuses, 41 is taken because higher
        $this->assertSame(41, $speedTable->mPerRoundToBonus(106)); // 41 is the closest bonus (higher in this case)

        $this->assertSame(40, $speedTable->kmPerHourToBonus(37)); // 40 is the closest bonus
        $this->assertSame(41, $speedTable->kmPerHourToBonus(38)); // 40 and 41 are closest bonuses, 41 is taken because higher
        $this->assertSame(41, $speedTable->kmPerHourToBonus(38)); // 41 is the closest bonus (higher in this case)

        $this->assertSame(59, $speedTable->mPerRoundToBonus(900));

        $this->assertSame(99, $speedTable->toBonus(new SpeedMeasurement(32000, SpeedMeasurement::KM_PER_HOUR)));
        $this->assertSame(99, $speedTable->kmPerHourToBonus(32000));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_value_to_bonus_cause_exception()
    {
        $speedTable = new SpeedTable();
        $speedTable->mPerRoundToBonus(0.09);
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_value_to_bonus_cause_exception()
    {
        $speedTable = new SpeedTable();
        $speedTable->kmPerHourToBonus(32001);
    }
}
