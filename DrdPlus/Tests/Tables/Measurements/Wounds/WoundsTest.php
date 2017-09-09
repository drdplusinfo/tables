<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Measurements\Wounds;

use DrdPlus\Tables\Measurements\Wounds\Wounds;
use DrdPlus\Tables\Table;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfMeasurement;

class WoundsTest extends AbstractTestOfMeasurement
{

    protected function createSutWithTable($sutClass, $amount, $unit, Table $table)
    {
        return new $sutClass($amount, $table, $unit);
    }

    protected function getDefaultUnit()
    {
        return Wounds::WOUNDS;
    }
}
