<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;

class VoulgesAndTridentsTable extends AbstractMeleeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/voulges_and_tridents.csv';
    }

}