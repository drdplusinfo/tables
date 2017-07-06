<?php
namespace DrdPlus\Tables\Armaments\Weapons\Melee;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;

/**
 * See PPH page 85, @link https://pph.drdplus.info/#tabulka_zbrani_jednorucni_zbrane
 * and @link https://pph.drdplus.info/#tabulka_zbrani_obourucni_zbrane
 */
class AxesTable extends MeleeWeaponsTable
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/axes.csv';
    }
}