<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;

/**
 * See PPH page 85, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_zbrani_jednorucni_zbrane
 */
class VoulgesAndTridentsTable extends MeleeWeaponsTable
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/voulges_and_tridents.csv';
    }

}