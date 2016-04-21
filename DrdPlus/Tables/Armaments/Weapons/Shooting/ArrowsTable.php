<?php
namespace DrdPlus\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTable;

class ArrowsTable extends AbstractShootingArmamentsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/arrows.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return ['projectile'];
    }

}