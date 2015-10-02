<?php
namespace DrdPlus\Tests\Tables\Experiences;

use DrdPlus\Tables\Wounds\WoundsTable;
use DrdPlus\Tests\Tables\AbstractTestOfBonus;

class ExperiencesBonusTest extends AbstractTestOfBonus
{
    protected function getTableInstance()
    {
        $tableClass = $this->getTableClass();

        return new $tableClass(new WoundsTable());
    }
}
