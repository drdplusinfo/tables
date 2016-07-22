<?php
namespace DrdPlus\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTable;

class DartsTable extends ShootingWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/darts.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return ['projectile'];
    }

}