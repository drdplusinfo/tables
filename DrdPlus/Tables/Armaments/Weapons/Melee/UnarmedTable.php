<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;

class UnarmedTable extends MeleeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/unarmed.csv';
    }

}