<?php
namespace DrdPlus\Tests\Tables\Weight;

use DrdPlus\Tables\Weight\Weight;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class WeightTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return Weight::KG;
    }
}
