<?php
namespace DrdPlus\Tests\Tables\Base\Wounds;

use DrdPlus\Tables\Base\Wounds\WoundsMeasurement;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class WoundsMeasurementTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return WoundsMeasurement::WOUNDS;
    }
}
