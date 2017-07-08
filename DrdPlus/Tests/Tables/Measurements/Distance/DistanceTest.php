<?php
namespace DrdPlus\Tests\Tables\Measurements\Distance;

use DrdPlus\Codes\Units\DistanceUnitCode;
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

        $inKm = new Distance($value = 123, $unit = DistanceUnitCode::KILOMETER, $distanceTable);
        self::assertSame((float)$value, $inKm->getValue());
        self::assertSame($unit, $inKm->getUnit());
        self::assertSame((float)$value, $inKm->getKilometers());
        self::assertSame((float)($value * 1000), $inKm->getMeters());
        self::assertSame(102, $inKm->getBonus()->getValue());

        $inM = new Distance($value = 456, $unit = DistanceUnitCode::METER, $distanceTable);
        self::assertSame((float)$value, $inM->getValue());
        self::assertSame($unit, $inM->getUnit());
        self::assertSame((float)$value, $inM->getMeters());
        self::assertSame((float)($value / 1000), $inM->getKilometers());
        self::assertSame(53, $inM->getBonus()->getValue());

        $inLightYears = new Distance($value = 1, $unit = DistanceUnitCode::LIGHT_YEAR, $distanceTable);
        self::assertSame((float)$value, $inLightYears->getValue());
        self::assertSame((float)$value, $inLightYears->getLightYears());
        self::assertSame($unit, $inLightYears->getUnit());
        self::assertSame(319, $inLightYears->getBonus()->getValue());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     */
    public function Invalid_unit_of_inherited_distance_is_detected()
    {
        /** @var Distance|\Mockery\MockInterface $distanceWithInvalidUnit */
        $distanceWithInvalidUnit = $this->mockery(Distance::class);
        $distanceWithInvalidUnit->shouldReceive('getUnit')
            ->andReturn('invalid unit');
        $distanceWithInvalidUnit->shouldDeferMissing();

        $distanceWithInvalidUnit->getMeters();
    }

    protected function getDefaultUnit()
    {
        return DistanceUnitCode::METER;
    }

    public function getAllUnits(): array
    {
        return [DistanceUnitCode::METER, DistanceUnitCode::KILOMETER, DistanceUnitCode::LIGHT_YEAR];
    }

    /**
     * @test
     */
    public function I_can_get_unit_as_a_code_instance()
    {
        $distanceTable = new DistanceTable();

        foreach ($this->getAllUnits() as $unitName) {
            $distance = new Distance(123.456, $unitName, $distanceTable);
            self::assertSame(DistanceUnitCode::getIt($unitName), $distance->getUnitCode());
        }
    }

}