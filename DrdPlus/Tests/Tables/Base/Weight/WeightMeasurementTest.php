<?php
namespace DrdPlus\Tests\Tables\Base\Weight;

use DrdPlus\Tables\Base\Weight\WeightMeasurement;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class WeightMeasurementTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return WeightMeasurement::KG;
    }
}
