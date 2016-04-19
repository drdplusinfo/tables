<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;

class AxesTable extends AbstractMeleeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/axes.csv';
    }
}