<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTableTest;

class BowsTableTest extends RangeWeaponsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangeWeaponCode::SHORT_BOW, RangeWeaponsTable::REQUIRED_STRENGTH, [-1, 3]],
            [RangeWeaponCode::SHORT_BOW, RangeWeaponsTable::OFFENSIVENESS, 2],
            [RangeWeaponCode::SHORT_BOW, RangeWeaponsTable::WOUNDS, 1],
            [RangeWeaponCode::SHORT_BOW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::SHORT_BOW, RangeWeaponsTable::RANGE, 24],
            [RangeWeaponCode::SHORT_BOW, RangeWeaponsTable::WEIGHT, 1.0],

            [RangeWeaponCode::LONG_BOW, RangeWeaponsTable::REQUIRED_STRENGTH, [5, 7]],
            [RangeWeaponCode::LONG_BOW, RangeWeaponsTable::OFFENSIVENESS, 3],
            [RangeWeaponCode::LONG_BOW, RangeWeaponsTable::WOUNDS, 4],
            [RangeWeaponCode::LONG_BOW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::LONG_BOW, RangeWeaponsTable::RANGE, 27],
            [RangeWeaponCode::LONG_BOW, RangeWeaponsTable::WEIGHT, 1.2],

            [RangeWeaponCode::SHORT_COMPOSITE_BOW, RangeWeaponsTable::REQUIRED_STRENGTH, [1, 6]],
            [RangeWeaponCode::SHORT_COMPOSITE_BOW, RangeWeaponsTable::OFFENSIVENESS, 3],
            [RangeWeaponCode::SHORT_COMPOSITE_BOW, RangeWeaponsTable::WOUNDS, 2],
            [RangeWeaponCode::SHORT_COMPOSITE_BOW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::SHORT_COMPOSITE_BOW, RangeWeaponsTable::RANGE, 26],
            [RangeWeaponCode::SHORT_COMPOSITE_BOW, RangeWeaponsTable::WEIGHT, 1.0],

            [RangeWeaponCode::LONG_COMPOSITE_BOW, RangeWeaponsTable::REQUIRED_STRENGTH, [5, 9]],
            [RangeWeaponCode::LONG_COMPOSITE_BOW, RangeWeaponsTable::OFFENSIVENESS, 4],
            [RangeWeaponCode::LONG_COMPOSITE_BOW, RangeWeaponsTable::WOUNDS, 5],
            [RangeWeaponCode::LONG_COMPOSITE_BOW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::LONG_COMPOSITE_BOW, RangeWeaponsTable::RANGE, 29],
            [RangeWeaponCode::LONG_COMPOSITE_BOW, RangeWeaponsTable::WEIGHT, 1.5],

            [RangeWeaponCode::POWER_BOW, RangeWeaponsTable::REQUIRED_STRENGTH, [7, 12]],
            [RangeWeaponCode::POWER_BOW, RangeWeaponsTable::OFFENSIVENESS, 5],
            [RangeWeaponCode::POWER_BOW, RangeWeaponsTable::WOUNDS, 6],
            [RangeWeaponCode::POWER_BOW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::POWER_BOW, RangeWeaponsTable::RANGE, 31],
            [RangeWeaponCode::POWER_BOW, RangeWeaponsTable::WEIGHT, 2.0],
        ];
    }

}
