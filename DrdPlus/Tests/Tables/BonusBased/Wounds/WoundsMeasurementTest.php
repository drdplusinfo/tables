<?php
namespace DrdPlus\Tests\Tables\BonusBased\Wounds;

use DrdPlus\Tables\BonusBased\Wounds\WoundsMeasurement;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class WoundsMeasurementTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return WoundsMeasurement::WOUNDS;
    }
}
