<?php
namespace DrdPlus\Tables\Armaments\Projectiles;

use DrdPlus\Tables\Armaments\Projectiles\Partials\ProjectilesTable;

class DartsTable extends ProjectilesTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/darts.csv';
    }

}