<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;

/**
 * See PPH page 85, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_zbrani_jednorucni_zbrane
 * and @link https://pph.drdplus.jaroslavtyc.com/#tabulka_zbrani_obourucni_zbrane
 */
class StaffsAndSpearsTable extends MeleeWeaponsTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/staffs_and_spears.csv';
    }

}