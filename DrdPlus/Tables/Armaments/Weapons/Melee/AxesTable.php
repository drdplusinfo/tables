<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;

class AxesTable extends MeleeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/axes.csv';
    }
}