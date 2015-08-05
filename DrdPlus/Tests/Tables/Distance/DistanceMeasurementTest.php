<?php
namespace DrdPlus\Tests\Tables\Distance;

use DrdPlus\Tables\Distance\DistanceMeasurement;
use DrdPlus\Tests\Tables\TestWithMockery;

class DistanceMeasurementTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_create_distance_measurement_in_meters_or_kilometers()
    {
        $inKm = new DistanceMeasurement($value = 123, $unit = DistanceMeasurement::KM);
        $this->assertSame((float)$value, $inKm->getValue());
        $this->assertSame($unit, $inKm->getUnit());
        $this->assertSame((float)$value, $inKm->toKilometers());
        $this->assertSame((float)($value * 1000), $inKm->toMeters());
        $inM = new DistanceMeasurement($value = 456, $unit = DistanceMeasurement::M);
        $this->assertSame((float)$value, $inM->getValue());
        $this->assertSame($unit, $inM->getUnit());
        $this->assertSame((float)$value, $inM->toMeters());
        $this->assertSame((float)($value / 1000), $inM->toKilometers());
    }


    /**
     * @test
     */
    public function I_can_add_value_in_same_unit()
    {
        $units = [DistanceMeasurement::KM, DistanceMeasurement::M, DistanceMeasurement::LIGHT_YEAR];
        foreach ($units as $unit) {
            $measurement = new DistanceMeasurement($amount = 123, $unit);
            $measurement->addInDifferentUnit($amount, $unit);
            $this->assertSame((float)$amount, $measurement->getValue());
            $this->assertSame($unit, $measurement->getUnit());
        }
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function I_cannot_add_in_different_unit()
    {
        $measurement = new DistanceMeasurement($amount = 123, DistanceMeasurement::M);
        $measurement->addInDifferentUnit($amount, 'non-existing-unit');
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\SameValueExpectedForSameUnit
     */
    public function I_cannot_add_different_value_with_same_unit()
    {
        $measurement = new DistanceMeasurement($amount = 123, $unit = DistanceMeasurement::M);
        $measurement->addInDifferentUnit($amount + 1, $unit);
    }

    /**
     * @test
     */
    public function I_can_add_value_in_correct_ratio_with_different_unit()
    {
        $measurement = new DistanceMeasurement($amount = 123, DistanceMeasurement::M);
        $measurement->addInDifferentUnit($amount / 1000, DistanceMeasurement::KM);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Distance\Exceptions\IncorrectRatio
     */
    public function I_cannot_add_incorrect_value_with_different_unit()
    {
        $measurement = new DistanceMeasurement($amount = 123, DistanceMeasurement::M);
        $measurement->addInDifferentUnit($amount, DistanceMeasurement::KM);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function I_cannot_use_unknown_unit_even_if_broke_the_main_check()
    {
        $measurement = new InvalidDistanceMeasurement($amount = 123, DistanceMeasurement::M);
        $measurement->addInDifferentUnit($amount, 'non-existing-unit');
    }

}

/** inner */
class InvalidDistanceMeasurement extends DistanceMeasurement
{
    protected function checkValueInDifferentUnit($value, $unit)
    {
        return; // disabling the check
    }
}
