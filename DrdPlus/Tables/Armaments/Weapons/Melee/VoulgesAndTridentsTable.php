<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;

class VoulgesAndTridentsTable extends MeleeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/voulges_and_tridents.csv';
    }

}