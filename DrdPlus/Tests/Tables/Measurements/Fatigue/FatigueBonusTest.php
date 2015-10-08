<?php
namespace DrdPlus\Tests\Tables\Measurements\Fatigue;

use DrdPlus\Tables\Measurements\Fatigue\FatigueTable;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfBonus;

class FatigueBonusTest extends AbstractTestOfBonus
{
    protected function getTableInstance()
    {
        return new FatigueTable(new WoundsTable());
    }
}
