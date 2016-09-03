<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Codes\Armaments\RangeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTableTest;

class ArrowsTableTest extends RangedWeaponsTableTest
{
    protected function getRowHeaderName()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangeWeaponCode::BASIC_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::BASIC_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::BASIC_ARROW, RangedWeaponsTable::WOUNDS, 0],
            [RangeWeaponCode::BASIC_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::BASIC_ARROW, RangedWeaponsTable::RANGE, 0],
            [RangeWeaponCode::BASIC_ARROW, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::BASIC_ARROW, RangedWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::WOUNDS, -1],
            [RangeWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::RANGE, 2],
            [RangeWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::WAR_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::WAR_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::WAR_ARROW, RangedWeaponsTable::WOUNDS, 2],
            [RangeWeaponCode::WAR_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::WAR_ARROW, RangedWeaponsTable::RANGE, -2],
            [RangeWeaponCode::WAR_ARROW, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::WAR_ARROW, RangedWeaponsTable::WEIGHT, 0.1],

            [RangeWeaponCode::PIERCING_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::PIERCING_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::PIERCING_ARROW, RangedWeaponsTable::WOUNDS, -1],
            [RangeWeaponCode::PIERCING_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::PIERCING_ARROW, RangedWeaponsTable::RANGE, 0],
            [RangeWeaponCode::PIERCING_ARROW, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::PIERCING_ARROW, RangedWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::WOUNDS, -1],
            [RangeWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::RANGE, 0],
            [RangeWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::OFFENSIVENESS, -1],
            [RangeWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::WOUNDS, -2],
            [RangeWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::RANGE, -1],
            [RangeWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::OFFENSIVENESS, -3],
            [RangeWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::WOUNDS, -3],
            [RangeWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangeWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::RANGE, -2],
            [RangeWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::SILVER_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::SILVER_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::SILVER_ARROW, RangedWeaponsTable::WOUNDS, 0],
            [RangeWeaponCode::SILVER_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::SILVER_ARROW, RangedWeaponsTable::RANGE, 0],
            [RangeWeaponCode::SILVER_ARROW, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::SILVER_ARROW, RangedWeaponsTable::WEIGHT, 0.05],
        ];
    }

}