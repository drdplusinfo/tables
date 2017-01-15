<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;

/**
 * See PPH page 85, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_zbrani_jednorucni_zbrane
 */
class SabersAndBowieKnifesTable extends MeleeWeaponsTable
{
    /**
     * @return string
     */
    protected function getDataFileName()
    {
        return __DIR__ . '/data/sabers_and_bowie_knifes.csv';
    }

}