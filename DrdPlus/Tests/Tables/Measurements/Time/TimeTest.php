<?php
namespace DrdPlus\Tests\Tables\Measurements\Time;

use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfMeasurement;

class TimeTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return Time::ROUND;
    }

    protected function getAllUnits()
    {
        return [
            Time::ROUND,
            Time::MINUTE,
            Time::HOUR,
            Time::DAY,
            Time::MONTH,
            Time::YEAR,
        ];
    }
}
