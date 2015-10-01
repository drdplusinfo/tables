<?php
namespace DrdPlus\Tests\Tables\Distance;

use DrdPlus\Tables\Distance\Distance;
use DrdPlus\Tables\Distance\DistanceTable;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class DistanceTest extends AbstractTestOfMeasurement
{

    /**
     * @test
     */
    public function I_can_create_distance_measurement_in_meters_or_kilometers()
    {
        $distanceTable = new DistanceTable();
        $inKm = new Distance($value = 123, $unit = Distance::KM, $distanceTable);
        $this->assertSame((float)$value, $inKm->getValue());
        $this->assertSame($unit, $inKm->getUnit());
        $this->assertSame((float)$value, $inKm->getKilometers());
        $this->assertSame((float)($value * 1000), $inKm->getMeters());
        $inM = new Distance($value = 456, $unit = Distance::M, $distanceTable);
        $this->assertSame((float)$value, $inM->getValue());
        $this->assertSame($unit, $inM->getUnit());
        $this->assertSame((float)$value, $inM->getMeters());
        $this->assertSame((float)($value / 1000), $inM->getKilometers());
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
