<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;

class MacesAndClubsTable extends AbstractMeleeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/maces_and_clubs.csv';
    }
}