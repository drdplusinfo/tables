<?php
namespace DrdPlus\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;

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