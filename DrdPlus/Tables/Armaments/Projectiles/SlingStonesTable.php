<?php
namespace DrdPlus\Tables\Armaments\Projectiles;

use DrdPlus\Tables\Armaments\Projectiles\Partials\ProjectilesTable;

/**
 * See PPH page 88 right column, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_strelnych_a_vrhacich_zbrani
 */
class SlingStonesTable extends ProjectilesTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/sling_stones.csv';
    }

}