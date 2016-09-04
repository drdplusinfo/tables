<?php
namespace DrdPlus\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;

class ThrowingWeaponsTable extends RangedWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/throwing_weapons.csv';
    }

    protected function getRowsHeader()
    {
        return ['weapon'];
    }

}