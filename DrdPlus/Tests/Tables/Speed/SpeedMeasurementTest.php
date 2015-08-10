<?php
namespace DrdPlus\Tests\Tables\Speed;

use DrdPlus\Tables\Speed\SpeedMeasurement;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class SpeedMeasurementTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return SpeedMeasurement::M_PER_ROUND;
    }

    /**
     * @test
     */
    public function I_can_add_kilometers_to_measurement_in_meters()
    {
        $speed = new SpeedMeasurement($meters = 123, SpeedMeasurement::M_PER_ROUND);
        $speed->addInDifferentUnit($kilometers = ($meters / 2), SpeedMeasurement::KM_PER_HOUR);
        $this->assertSame((float)$meters, $speed->getValue());
        $this->assertSame((float)$meters, $speed->toMetersPerRound());
        $this->assertSame((float)$kilometers, $speed->toKilometersPerHour());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Speed\Exceptions\KilometersHaveToBeLesserThanKilometers
     */
    public function I_cannot_add_same_kilometers_to_measurement_in_meters()
    {
        $speed = new SpeedMeasurement($value = 123, SpeedMeasurement::M_PER_ROUND);
        $speed->addInDifferentUnit($value, SpeedMeasurement::KM_PER_HOUR);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Speed\Exceptions\KilometersHaveToBeLesserThanKilometers
     */
    public function I_cannot_add_more_kilometers_to_measurement_in_meters()
    {
        $speed = new SpeedMeasurement($value = 123, SpeedMeasurement::M_PER_ROUND);
        $speed->addInDifferentUnit($value + 1, SpeedMeasurement::KM_PER_HOUR);
    }

    /**
     * @test
     */
    public function I_can_add_meters_to_measurement_in_kilometers()
    {
        $speed = new SpeedMeasurement($kilometers = 123, SpeedMeasurement::KM_PER_HOUR);
        $speed->addInDifferentUnit($meters = ($kilometers * 2), SpeedMeasurement::M_PER_ROUND);
        $this->assertSame((float)$kilometers, $speed->getValue());
        $this->assertSame((float)$kilometers, $speed->toKilometersPerHour());
        $this->assertSame((float)$meters, $speed->toMetersPerRound());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Speed\Exceptions\MetersHaveToBeGreaterThanKilometers
     */
    public function I_cannot_add_same_meters_to_measurement_in_kilometers()
    {
        $speed = new SpeedMeasurement($value = 123, SpeedMeasurement::KM_PER_HOUR);
        $speed->addInDifferentUnit($value, SpeedMeasurement::M_PER_ROUND);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Speed\Exceptions\MetersHaveToBeGreaterThanKilometers
     */
    public function I_cannot_add_less_meters_to_measurement_in_kilometers()
    {
        $speed = new SpeedMeasurement($value = 123, SpeedMeasurement::KM_PER_HOUR);
        $speed->addInDifferentUnit($value - 1, SpeedMeasurement::M_PER_ROUND);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Speed\Exceptions\MissingConversion
     */
    public function I_cannot_get_kilometers_from_meters_without_set()
    {
        $speed = new SpeedMeasurement($value = 123, SpeedMeasurement::M_PER_ROUND);
        $this->assertSame((float)$value, $speed->toMetersPerRound());
        $speed->toKilometersPerHour();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Speed\Exceptions\MissingConversion
     */
    public function I_cannot_get_meters_from_kilometers_without_set()
    {
        $speed = new SpeedMeasurement($value = 123, SpeedMeasurement::KM_PER_HOUR);
        $this->assertSame((float)$value, $speed->toKilometersPerHour());
        $speed->toMetersPerRound();
    }

}
