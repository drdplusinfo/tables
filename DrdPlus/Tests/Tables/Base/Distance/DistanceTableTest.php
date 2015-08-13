<?php
namespace DrdPlus\Tests\Tables\Base\Distance;

use DrdPlus\Tables\Base\Distance\DistanceMeasurement;
use DrdPlus\Tables\Base\Distance\DistanceTable;
use DrdPlus\Tests\Tables\TestWithMockery;

class DistanceTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function can_convert_bonus_to_distance()
    {
        $distanceTable = new DistanceTable();

        $this->assertSame(0.01, $distanceTable->toMeters(-40));
        $this->assertSame(0.00001, $distanceTable->toKilometers(-40));

        $this->assertSame(1.0, $distanceTable->toMeters(0));
        $this->assertSame(0.001, $distanceTable->toKilometers(0));

        $this->assertSame(900000.0, $distanceTable->toMeters(119));
        $this->assertSame(900.0, $distanceTable->toKilometers(119));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_bonus_to_distance_cause_exception()
    {
        $distanceTable = new DistanceTable();
        $distanceTable->toMeters(-41);
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_bonus_to_distance_cause_exception()
    {
        $distanceTable = new DistanceTable();
        $distanceTable->toMeters(120);
    }

    /**
     * @test
     */
    public function can_convert_distance_to_bonus()
    {
        $distanceTable = new DistanceTable();

        // 0.01 matches more bonuses - the lowest is taken
        $this->assertSame(-40, $distanceTable->toBonus(new DistanceMeasurement(0.01, DistanceMeasurement::M)));
        $this->assertSame(-40, $distanceTable->metersToBonus(0.01));

        $this->assertSame(0, $distanceTable->metersToBonus(1));

        $this->assertSame(40, $distanceTable->metersToBonus(104)); // 40 is the closest bonus
        $this->assertSame(41, $distanceTable->metersToBonus(105)); // 40 and 41 are closest bonuses, 41 is taken because higher
        $this->assertSame(41, $distanceTable->metersToBonus(106)); // 41 is the closest bonus (higher in this case)

        $this->assertSame(119, $distanceTable->kilometersToBonus(900));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_value_to_bonus_cause_exception()
    {
        $distanceTable = new DistanceTable();
        $distanceTable->metersToBonus(0.009);
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_value_to_bonus_cause_exception()
    {
        $distanceTable = new DistanceTable();
        $distanceTable->kilometersToBonus(901);
    }
}
