<?php
namespace DrdPlus\Tests\Tables\Time;

use DrdPlus\Tables\Time\Time;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

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
