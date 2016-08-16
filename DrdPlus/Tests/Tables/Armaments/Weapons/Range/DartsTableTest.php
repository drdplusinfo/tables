<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTableTest;

class DartsTableTest extends RangeWeaponsTableTest
{
    protected function getRowHeaderName()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangeWeaponCode::BASIC_DART, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::BASIC_DART, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::BASIC_DART, RangeWeaponsTable::WOUNDS, 0],
            [RangeWeaponCode::BASIC_DART, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::BASIC_DART, RangeWeaponsTable::RANGE, 0],
            [RangeWeaponCode::BASIC_DART, RangeWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::WAR_DART, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::WAR_DART, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::WAR_DART, RangeWeaponsTable::WOUNDS, 2],
            [RangeWeaponCode::WAR_DART, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::WAR_DART, RangeWeaponsTable::RANGE, -2],
            [RangeWeaponCode::WAR_DART, RangeWeaponsTable::WEIGHT, 0.1],

            [RangeWeaponCode::PIERCING_DART, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::PIERCING_DART, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::PIERCING_DART, RangeWeaponsTable::WOUNDS, -1],
            [RangeWeaponCode::PIERCING_DART, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::PIERCING_DART, RangeWeaponsTable::RANGE, 0],
            [RangeWeaponCode::PIERCING_DART, RangeWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::HOLLOW_DART, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::HOLLOW_DART, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::HOLLOW_DART, RangeWeaponsTable::WOUNDS, -1],
            [RangeWeaponCode::HOLLOW_DART, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::HOLLOW_DART, RangeWeaponsTable::RANGE, 0],
            [RangeWeaponCode::HOLLOW_DART, RangeWeaponsTable::WEIGHT, 0.05],

            [RangeWeaponCode::SILVER_DART, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::SILVER_DART, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::SILVER_DART, RangeWeaponsTable::WOUNDS, 0],
            [RangeWeaponCode::SILVER_DART, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::SILVER_DART, RangeWeaponsTable::RANGE, 0],
            [RangeWeaponCode::SILVER_DART, RangeWeaponsTable::WEIGHT, 0.05],
        ];
    }

}
