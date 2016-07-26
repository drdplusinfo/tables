<?php
namespace DrdPlus\Tables\Armaments\Weapons\Range;

use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;

class CrossbowsTable extends RangeWeaponsTable
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