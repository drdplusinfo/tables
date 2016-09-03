<?php
namespace DrdPlus\Tables\Armaments\Weapons\Range;

use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTable;

class CrossbowsTable extends RangedWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/crossbows.csv';
    }

    protected function getRowsHeader()
    {
        return ['weapon'];
    }

}