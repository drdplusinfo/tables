<?php
namespace DrdPlus\Tests\Tables\Wounds;

use DrdPlus\Tables\Wounds\Wounds;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class WoundsTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return Wounds::WOUNDS;
    }
}
