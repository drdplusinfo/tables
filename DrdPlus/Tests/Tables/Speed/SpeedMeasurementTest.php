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

}
