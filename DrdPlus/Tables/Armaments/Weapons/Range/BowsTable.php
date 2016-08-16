<?php
namespace DrdPlus\Tables\Armaments\Weapons\Range;

use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;

class BowsTable extends RangeWeaponsTable
{
    protected function getDataFileName()
    {
        return __DIR__ . '/data/bows.csv';
    }

    const MAXIMAL_APPLICABLE_STRENGTH = 'maximal_applicable_strength';

    protected function getExpectedDataHeaderNamesToTypes()
    {
        return [
            self::REQUIRED_STRENGTH => self::INTEGER,
            self::MAXIMAL_APPLICABLE_STRENGTH => self::INTEGER,
            self::OFFENSIVENESS => self::INTEGER,
            self::WOUNDS => self::INTEGER,
            self::WOUNDS_TYPE => self::STRING,
            self::RANGE => self::INTEGER,
            self::WEIGHT => self::FLOAT,
        ];
    }

    /**
     * @param string $weaponCode
     * @return int
     */
    public function getMaximalApplicableStrengthOf($weaponCode)
    {
        return self::getValueOf($weaponCode, self::MAXIMAL_APPLICABLE_STRENGTH);
    }

    protected function getRowsHeader()
    {
        return ['weapon'];
    }

}