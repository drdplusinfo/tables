<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;

class SabersAndBowieKnifesTable extends MeleeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/sabers_and_bowie_knifes.csv';
    }

}