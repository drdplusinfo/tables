<?php
namespace DrdPlus\Tests\Tables\Wounds;

use DrdPlus\Tables\Wounds\WoundsMeasurement;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class WoundsMeasurementTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return WoundsMeasurement::WOUNDS;
    }
}
