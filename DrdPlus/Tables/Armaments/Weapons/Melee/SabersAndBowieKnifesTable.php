<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;

class SabersAndBowieKnifesTable extends AbstractMeleeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/sabers_and_bowie_knifes.csv';
    }

}