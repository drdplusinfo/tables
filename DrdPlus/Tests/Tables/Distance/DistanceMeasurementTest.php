<?php
namespace DrdPlus\Tests\Tables\Distance;

use DrdPlus\Tables\Distance\DistanceMeasurement;
use DrdPlus\Tests\Tables\TestWithMockery;

class DistanceMeasurementTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_create_distance_measurement()
    {
        $inKm = new DistanceMeasurement($value = 123, $unit = DistanceMeasurement::KM);
        $this->assertSame((float)$value, $inKm->getValue());
        $this->assertSame($unit, $inKm->getUnit());
        $this->assertSame((float)$value, $inKm->toKilometers());
        $this->assertSame((float)($value * 1000), $inKm->toMeters());
        $inM = new DistanceMeasurement($value = 456, $unit = DistanceMeasurement::M);
        $this->assertSame((float)$value, $inM->getValue());
        $this->assertSame($unit, $inM->getUnit());
        $this->assertSame((float)$value, $inKm->toMeters());
        $this->assertSame((float)($value / 1000), $inKm->toKilometers());
    }
}
