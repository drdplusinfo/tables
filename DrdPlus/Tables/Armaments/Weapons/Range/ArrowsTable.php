<?php
namespace DrdPlus\Tables\Armaments\Weapons\Range;

use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;

class ArrowsTable extends RangeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/arrows.csv';
    }

    protected function getRowsHeader()
    {
        return ['projectile'];
    }

}