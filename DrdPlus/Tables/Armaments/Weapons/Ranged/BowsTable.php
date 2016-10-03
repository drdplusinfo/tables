<?php
namespace DrdPlus\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use Granam\String\StringInterface;

class BowsTable extends RangedWeaponsTable
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
            self::MAXIMAL_APPLICABLE_STRENGTH => self::POSITIVE_INTEGER,
            self::OFFENSIVENESS => self::INTEGER,
            self::WOUNDS => self::INTEGER,
            self::WOUNDS_TYPE => self::STRING,
            self::RANGE => self::POSITIVE_INTEGER,
            self::COVER => self::POSITIVE_INTEGER,
            self::WEIGHT => self::FLOAT,
            self::TWO_HANDED => self::BOOLEAN,
        ];
    }

    /**
     * @param string|StringInterface|RangedWeaponCode $bowCode
     * @return int
     * @throws Exceptions\UnknownBow
     */
    public function getMaximalApplicableStrengthOf($bowCode)
    {
        try {
            return $this->getValueOf($bowCode, self::MAXIMAL_APPLICABLE_STRENGTH);
        } catch (UnknownRangedWeapon $unknownRangedWeapon) {
            throw new Exceptions\UnknownBow("Unknown bow '{$bowCode}'");
        }
    }

    protected function getRowsHeader()
    {
        return ['weapon'];
    }

}