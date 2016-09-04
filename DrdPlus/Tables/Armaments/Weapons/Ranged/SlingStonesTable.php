<?php
namespace DrdPlus\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;

class SlingStonesTable extends RangedWeaponsTable
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