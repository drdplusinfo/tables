<?php
namespace DrdPlus\Tests\Tables\Fatigue;

use DrdPlus\Tables\Fatigue\FatigueTable;
use DrdPlus\Tables\Wounds\WoundsTable;
use DrdPlus\Tests\Tables\AbstractTestOfBonus;

class FatigueBonusTest extends AbstractTestOfBonus
{
    protected function getTableInstance()
    {
        return new FatigueTable(new WoundsTable());
    }
}
