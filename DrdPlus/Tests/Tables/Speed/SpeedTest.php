<?php
namespace DrdPlus\Tests\Tables\Speed;

use DrdPlus\Tables\Speed\Speed;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class SpeedTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return Speed::M_PER_ROUND;
    }

    protected function getAllUnits()
    {
        return [Speed::M_PER_ROUND, Speed::KM_PER_HOUR];
    }
}
