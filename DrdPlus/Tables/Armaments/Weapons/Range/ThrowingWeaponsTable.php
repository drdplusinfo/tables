<?php
namespace DrdPlus\Tables\Armaments\Weapons\Range;

use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;

class ThrowingWeaponsTable extends RangeWeaponsTable
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