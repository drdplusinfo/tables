<?php
namespace DrdPlus\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTable;

class ThrowingWeaponsTable extends AbstractShootingArmamentsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/throwing_weapons.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return ['weapon'];
    }

}