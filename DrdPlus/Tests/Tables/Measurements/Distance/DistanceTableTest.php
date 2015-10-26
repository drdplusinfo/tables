<?php
namespace DrdPlus\Tests\Tables\Measurements\Distance;

use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tables\Measurements\Distance\DistanceBonus;
use DrdPlus\Tables\Measurements\Distance\DistanceTable;
use DrdPlus\Tools\Tests\TestWithMockery;

class DistanceTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_convert_bonus_to_distance_and_back()
    {
        $distanceTable = new DistanceTable();

        $bonus = new DistanceBonus(-40, $distanceTable);
        $distance = $distanceTable->toDistance($bonus);
        $this->assertSame(0.01, $distance->getMeters());
        $this->assertSame(0.00001, $distance->getKilometers());
        $this->assertSame($bonus->getValue(), $distance->getBonus()->getValue());

        $bonus = new DistanceBonus(0, $distanceTable);
        $distance = $distanceTable->toDistance($bonus);
        $this->assertSame(1.0, $distance->getMeters());
        $this->assertSame(0.001, $distance->getKilometers());
        $this->assertSame($bonus->getValue(), $distance->getBonus()->getValue());

        $bonus = new DistanceBonus(119, $distanceTable);
        $distance = $distanceTable->toDistance($bonus);
        $this->assertSame(900000.0, $distance->getMeters());
        $this->assertSame(900.0, $distance->getKilometers());
        $this->assertSame($bonus->getValue(), $distance->getBonus()->getValue());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_low_bonus_to_distance_cause_exception()
    {
        $distanceTable = new DistanceTable();
        $distanceTable->toDistance(new DistanceBonus(-41, $distanceTable));
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_bonus_to_distance_cause_exception()
    {
        $distanceTable = new DistanceTable();
        $distanceTable->toDistance(new DistanceBonus(120, $distanceTable));
    }

    /**
     * @test
     */
    public function I_can_convert_distance_to_bonus()
    {
        $distanceTable = new DistanceTable();

        // 0.01 matches more bonuses - the lowest is taken
        $distance = new Distance(0.01, Distance::M, $distanceTable);
        $this->assertSame(-40, $distance->getBonus()->getValue());

        $distance = new Distance(1, Distance::M, $distanceTable);
        $this->assertSame(0, $distance->getBonus()->getValue());

        $distance = new Distance(104, Distance::M, $distanceTable);
        $this->assertSame(40, $distance->getBonus()->getValue()); // 40 is the closest bonus
        $distance = new Distance(105, Distance::M, $distanceTable);
        $this->assertSame(41, $distance->getBonus()->getValue()); // 40 and 41 are closest bonuses, 41 is taken because higher
        $distance = new Distance(106, Distance::M, $distanceTable);
        $this->assertSame(41, $distance->getBonus()->getValue()); // 41 is the closest bonus (higher in this case)

        $distance = new Distance(900, Distance::KM, $distanceTable);
        $this->assertSame(119, $distance->getBonus()->getValue());
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function I_can_not_convert_too_low_value_to_bonus()
    {
        $distanceTable = new DistanceTable();
        $distance = new Distance(0.009, Distance::M, $distanceTable);
        $distance->getBonus();
    }

    /**
     * @test
     * @expectedException \OutOfRangeException
     */
    public function too_high_value_to_bonus_cause_exception()
    {
        $distanceTable = new DistanceTable();
        $distance = new Distance(901, Distance::KM, $distanceTable);
        $distance->getBonus();
    }
}
