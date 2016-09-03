<?php
namespace DrdPlus\Tables\Armaments\Weapons\Range;

use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTable;

class ArrowsTable extends RangedWeaponsTable
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