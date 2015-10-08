<?php
namespace DrdPlus\Tests\Tables\Measurements\Speed;

use DrdPlus\Tables\Measurements\Speed\Speed;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfMeasurement;

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
