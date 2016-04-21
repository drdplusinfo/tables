<?php
namespace DrdPlus\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\AbstractShootingArmamentsTable;

class BowsTable extends AbstractShootingArmamentsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/bows.csv';
    }

    protected function getExpectedDataHeader()
    {
        $expectedDataHeader = parent::getExpectedDataHeader();
        // overloading for special format of melee fight and max applicable strength
        $expectedDataHeader[self::REQUIRED_STRENGTH_HEADER] = self::SLASH_ARRAY_OF_INTEGERS;

        return $expectedDataHeader;
    }

    protected function getExpectedRowsHeader()
    {
        return ['weapon'];
    }

}