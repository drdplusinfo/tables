<?php
namespace DrdPlus\Tests\Tables\Weight;

use DrdPlus\Tables\Weight\WeightMeasurement;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class WeightMeasurementTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return WeightMeasurement::KG;
    }
}
