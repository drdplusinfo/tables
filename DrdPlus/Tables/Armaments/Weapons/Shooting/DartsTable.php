<?php
namespace DrdPlus\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTable;

class DartsTable extends AbstractShootingArmamentsTable
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