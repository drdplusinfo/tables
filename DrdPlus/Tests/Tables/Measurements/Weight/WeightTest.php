<?php
namespace DrdPlus\Tests\Tables\Measurements\Weight;

use DrdPlus\Tables\Measurements\Weight\Weight;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfMeasurement;

class WeightTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return Weight::KG;
    }
}
