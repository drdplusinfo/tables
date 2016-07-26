<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTableTest;

class ArrowsTableTest extends RangeWeaponsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangeWeaponCode::BASIC_ARROW, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::BASIC_ARROW, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::BASIC_ARROW, RangeWeaponsTable::WOUNDS, 0],
            [RangeWeaponCode::BASIC_ARROW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::BASIC_ARROW, RangeWeaponsTable::RANGE, 0],
            [RangeWeaponCode::BASIC_ARROW, RangeWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::LONG_RANGE_ARROW, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::LONG_RANGE_ARROW, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::LONG_RANGE_ARROW, RangeWeaponsTable::WOUNDS, -1],
            [RangeWeaponCode::LONG_RANGE_ARROW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::LONG_RANGE_ARROW, RangeWeaponsTable::RANGE, 2],
            [RangeWeaponCode::LONG_RANGE_ARROW, RangeWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::WAR_ARROW, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::WAR_ARROW, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::WAR_ARROW, RangeWeaponsTable::WOUNDS, 2],
            [RangeWeaponCode::WAR_ARROW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::WAR_ARROW, RangeWeaponsTable::RANGE, -2],
            [RangeWeaponCode::WAR_ARROW, RangeWeaponsTable::WEIGHT, 0.1],

            [RangeWeaponCode::PIERCING_ARROW, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::PIERCING_ARROW, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::PIERCING_ARROW, RangeWeaponsTable::WOUNDS, -1],
            [RangeWeaponCode::PIERCING_ARROW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::PIERCING_ARROW, RangeWeaponsTable::RANGE, 0],
            [RangeWeaponCode::PIERCING_ARROW, RangeWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::HOLLOW_ARROW, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::HOLLOW_ARROW, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::HOLLOW_ARROW, RangeWeaponsTable::WOUNDS, -1],
            [RangeWeaponCode::HOLLOW_ARROW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::HOLLOW_ARROW, RangeWeaponsTable::RANGE, 0],
            [RangeWeaponCode::HOLLOW_ARROW, RangeWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::CRIPPLING_ARROW, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::CRIPPLING_ARROW, RangeWeaponsTable::OFFENSIVENESS, -1],
            [RangeWeaponCode::CRIPPLING_ARROW, RangeWeaponsTable::WOUNDS, -2],
            [RangeWeaponCode::CRIPPLING_ARROW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::CRIPPLING_ARROW, RangeWeaponsTable::RANGE, -1],
            [RangeWeaponCode::CRIPPLING_ARROW, RangeWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::INCENDIARY_ARROW, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::INCENDIARY_ARROW, RangeWeaponsTable::OFFENSIVENESS, -3],
            [RangeWeaponCode::INCENDIARY_ARROW, RangeWeaponsTable::WOUNDS, -3],
            [RangeWeaponCode::INCENDIARY_ARROW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangeWeaponCode::INCENDIARY_ARROW, RangeWeaponsTable::RANGE, -2],
            [RangeWeaponCode::INCENDIARY_ARROW, RangeWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::SILVER_ARROW, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::SILVER_ARROW, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::SILVER_ARROW, RangeWeaponsTable::WOUNDS, 0],
            [RangeWeaponCode::SILVER_ARROW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::SILVER_ARROW, RangeWeaponsTable::RANGE, 0],
            [RangeWeaponCode::SILVER_ARROW, RangeWeaponsTable::WEIGHT, 0.05],
        ];
    }

}
