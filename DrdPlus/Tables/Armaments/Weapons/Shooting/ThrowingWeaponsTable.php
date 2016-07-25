<?php
namespace DrdPlus\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTable;

class ThrowingWeaponsTable extends ShootingWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/throwing_weapons.csv';
    }

    protected function getRowsHeader()
    {
        return ['weapon'];
    }

}