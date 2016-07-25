<?php
namespace DrdPlus\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTable;

class CrossbowsTable extends ShootingWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/crossbows.csv';
    }

    protected function getRowsHeader()
    {
        return ['weapon'];
    }

}