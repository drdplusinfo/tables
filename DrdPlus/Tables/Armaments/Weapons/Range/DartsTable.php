<?php
namespace DrdPlus\Tables\Armaments\Weapons\Range;

use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTable;

class DartsTable extends RangedWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/darts.csv';
    }

    protected function getRowsHeader()
    {
        return ['projectile'];
    }

}