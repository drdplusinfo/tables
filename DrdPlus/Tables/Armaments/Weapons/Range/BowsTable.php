<?php
namespace DrdPlus\Tables\Armaments\Weapons\Range;

use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;

class BowsTable extends RangeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/bows.csv';
    }

    protected function getExpectedDataHeaderNamesToTypes()
    {
        $expectedDataHeader = parent::getExpectedDataHeaderNamesToTypes();
        // overloading for special format of melee fight and max applicable strength
        $expectedDataHeader[self::REQUIRED_STRENGTH] = self::SLASH_ARRAY_OF_INTEGERS;

        return $expectedDataHeader;
    }

    protected function getRowsHeader()
    {
        return ['weapon'];
    }

}