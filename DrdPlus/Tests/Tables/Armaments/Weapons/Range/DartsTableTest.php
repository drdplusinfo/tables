<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Codes\Armaments\RangeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTableTest;

class DartsTableTest extends RangedWeaponsTableTest
{
    protected function getRowHeaderName()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangeWeaponCode::BASIC_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::BASIC_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::BASIC_DART, RangedWeaponsTable::WOUNDS, 0],
            [RangeWeaponCode::BASIC_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::BASIC_DART, RangedWeaponsTable::RANGE, 0],
            [RangeWeaponCode::BASIC_DART, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::BASIC_DART, RangedWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::WAR_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::WAR_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::WAR_DART, RangedWeaponsTable::WOUNDS, 2],
            [RangeWeaponCode::WAR_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::WAR_DART, RangedWeaponsTable::RANGE, -2],
            [RangeWeaponCode::WAR_DART, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::WAR_DART, RangedWeaponsTable::WEIGHT, 0.1],

            [RangeWeaponCode::PIERCING_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::PIERCING_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::PIERCING_DART, RangedWeaponsTable::WOUNDS, -1],
            [RangeWeaponCode::PIERCING_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::PIERCING_DART, RangedWeaponsTable::RANGE, 0],
            [RangeWeaponCode::PIERCING_DART, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::PIERCING_DART, RangedWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::HOLLOW_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::HOLLOW_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::HOLLOW_DART, RangedWeaponsTable::WOUNDS, -1],
            [RangeWeaponCode::HOLLOW_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::HOLLOW_DART, RangedWeaponsTable::RANGE, 0],
            [RangeWeaponCode::HOLLOW_DART, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::HOLLOW_DART, RangedWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::SILVER_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::SILVER_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::SILVER_DART, RangedWeaponsTable::WOUNDS, 0],
            [RangeWeaponCode::SILVER_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::SILVER_DART, RangedWeaponsTable::RANGE, 0],
            [RangeWeaponCode::SILVER_DART, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::SILVER_DART, RangedWeaponsTable::WEIGHT, 0.05],
        ];
    }

}