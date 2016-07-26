<?php
namespace DrdPlus\Tables\Armaments\Weapons\Range;

use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;

class SlingStonesTable extends RangeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/sling_stones.csv';
    }

    protected function getRowsHeader()
    {
        return ['projectile'];
    }

}