<?php
namespace DrdPlus\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;

/**
 * See PPH page 88 right column, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_strelnych_a_vrhacich_zbrani
 */
class CrossbowsTable extends RangedWeaponsTable
{
    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/crossbows.csv';
    }

    const WEAPON = 'weapon';

    /**
     * @return array|string[]
     */
    protected function getRowsHeader(): array
    {
        return [self::WEAPON];
    }

}