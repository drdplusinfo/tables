<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;

class StaffsAndSpearsTable extends MeleeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ .'/data/staffs_and_spears.csv';
    }

}