<?php
namespace DrdPlus\Tests\Tables\Measurements\Speed;

use DrdPlus\Codes\SpeedUnitCode;
use DrdPlus\Tables\Measurements\Speed\Speed;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfMeasurement;

class SpeedTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return SpeedUnitCode::METERS_PER_ROUND;
    }

    protected function getAllUnits(): array
    {
        return SpeedUnitCode::getPossibleValues();
    }

    /**
     * @test
     */
    public function I_can_get_unit_as_code()
    {
        $meters = new Speed(123, SpeedUnitCode::METERS_PER_ROUND, new SpeedTable());
        self::assertSame(SpeedUnitCode::getIt(SpeedUnitCode::METERS_PER_ROUND), $meters->getUnitCode());
        $kilometers = new Speed(465, SpeedUnitCode::KILOMETERS_PER_HOUR, new SpeedTable());
        self::assertSame(SpeedUnitCode::getIt(SpeedUnitCode::KILOMETERS_PER_HOUR), $kilometers->getUnitCode());
    }
}