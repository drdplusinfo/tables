<?php
namespace DrdPlus\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTable;

class CrossbowsTable extends AbstractShootingArmamentsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/crossbows.csv';
    }

    protected function getExpectedRowsHeader()
    {
        return ['weapon'];
    }

}