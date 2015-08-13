<?php
namespace DrdPlus\Tests\Tables\BonusBased\Weight;

use DrdPlus\Tables\BonusBased\Weight\WeightMeasurement;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class WeightMeasurementTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return WeightMeasurement::KG;
    }
}
