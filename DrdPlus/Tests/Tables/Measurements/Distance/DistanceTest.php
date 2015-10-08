<?php
namespace DrdPlus\Tests\Tables\Measurements\Distance;

use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tables\Measurements\Distance\DistanceTable;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfMeasurement;

class DistanceTest extends AbstractTestOfMeasurement
{

    /**
     * @test
     */
    public function I_can_create_distance_measurement_in_meters_or_kilometers_or_light_years()
    {
        $distanceTable = new DistanceTable();

        $inKm = new Distance($value = 123, $unit = Distance::KM, $distanceTable);
        $this->assertSame((float)$value, $inKm->getValue());
        $this->assertSame($unit, $inKm->getUnit());
        $this->assertSame((float)$value, $inKm->getKilometers());
        $this->assertSame((float)($value * 1000), $inKm->getMeters());
        $this->assertSame(102, $inKm->getBonus()->getValue());

        $inM = new Distance($value = 456, $unit = Distance::M, $distanceTable);
        $this->assertSame((float)$value, $inM->getValue());
        $this->assertSame($unit, $inM->getUnit());
        $this->assertSame((float)$value, $inM->getMeters());
        $this->assertSame((float)($value / 1000), $inM->getKilometers());
        $this->assertSame(53, $inM->getBonus()->getValue());

        $inLightYears = new Distance($value = 1, $unit = Distance::LIGHT_YEAR, $distanceTable);
        $this->assertSame((float)$value, $inLightYears->getValue());
        $this->assertSame((float)$value, $inLightYears->getLightYears());
        $this->assertSame($unit, $inLightYears->getUnit());
        $this->assertSame(319, $inLightYears->getBonus()->getValue());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     */
    public function Invalid_unit_of_inherited_distance_is_detected()
    {
        $distanceTable = new DistanceTable();

        $invalid = new TestOfDistanceWithInvalidUnit(123, Distance::KM, $distanceTable);
        $invalid->getMeters();
    }

    protected function getDefaultUnit()
    {
        return Distance::M;
    }

    public function getAllUnits()
    {
        return [Distance::M, Distance::KM, Distance::LIGHT_YEAR];
    }

}

/** inner */
class TestOfDistanceWithInvalidUnit extends Distance
{
    public function getUnit()
    {
        return 'invalid unit';
    }
}
