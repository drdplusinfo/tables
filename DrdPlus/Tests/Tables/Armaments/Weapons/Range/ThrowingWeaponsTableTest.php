<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTableTest;

class ThrowingWeaponsTableTest extends RangeWeaponsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangeWeaponCode::ROCK, RangeWeaponsTable::REQUIRED_STRENGTH, -2],
            [RangeWeaponCode::ROCK, RangeWeaponsTable::OFFENSIVENESS, 2],
            [RangeWeaponCode::ROCK, RangeWeaponsTable::WOUNDS, -2],
            [RangeWeaponCode::ROCK, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangeWeaponCode::ROCK, RangeWeaponsTable::RANGE, 20],
            [RangeWeaponCode::ROCK, RangeWeaponsTable::WEIGHT, 0.3],

            [RangeWeaponCode::THROWING_DAGGER, RangeWeaponsTable::REQUIRED_STRENGTH, 0],
            [RangeWeaponCode::THROWING_DAGGER, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::THROWING_DAGGER, RangeWeaponsTable::WOUNDS, 1],
            [RangeWeaponCode::THROWING_DAGGER, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::THROWING_DAGGER, RangeWeaponsTable::RANGE, 14],
            [RangeWeaponCode::THROWING_DAGGER, RangeWeaponsTable::WEIGHT, 0.2],

            [RangeWeaponCode::LIGHT_THROWING_AXE, RangeWeaponsTable::REQUIRED_STRENGTH, 2],
            [RangeWeaponCode::LIGHT_THROWING_AXE, RangeWeaponsTable::OFFENSIVENESS, 1],
            [RangeWeaponCode::LIGHT_THROWING_AXE, RangeWeaponsTable::WOUNDS, 2],
            [RangeWeaponCode::LIGHT_THROWING_AXE, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [RangeWeaponCode::LIGHT_THROWING_AXE, RangeWeaponsTable::RANGE, 12],
            [RangeWeaponCode::LIGHT_THROWING_AXE, RangeWeaponsTable::WEIGHT, 0.7],

            [RangeWeaponCode::WAR_THROWING_AXE, RangeWeaponsTable::REQUIRED_STRENGTH, 2],
            [RangeWeaponCode::WAR_THROWING_AXE, RangeWeaponsTable::OFFENSIVENESS, 1],
            [RangeWeaponCode::WAR_THROWING_AXE, RangeWeaponsTable::WOUNDS, 5],
            [RangeWeaponCode::WAR_THROWING_AXE, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [RangeWeaponCode::WAR_THROWING_AXE, RangeWeaponsTable::RANGE, 10],
            [RangeWeaponCode::WAR_THROWING_AXE, RangeWeaponsTable::WEIGHT, 1.0],

            [RangeWeaponCode::THROWING_HAMMER, RangeWeaponsTable::REQUIRED_STRENGTH, 5],
            [RangeWeaponCode::THROWING_HAMMER, RangeWeaponsTable::OFFENSIVENESS, 2],
            [RangeWeaponCode::THROWING_HAMMER, RangeWeaponsTable::WOUNDS, 7],
            [RangeWeaponCode::THROWING_HAMMER, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangeWeaponCode::THROWING_HAMMER, RangeWeaponsTable::RANGE, 9],
            [RangeWeaponCode::THROWING_HAMMER, RangeWeaponsTable::WEIGHT, 1.5],

            [RangeWeaponCode::SHURIKEN, RangeWeaponsTable::REQUIRED_STRENGTH, -1],
            [RangeWeaponCode::SHURIKEN, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::SHURIKEN, RangeWeaponsTable::WOUNDS, 1],
            [RangeWeaponCode::SHURIKEN, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [RangeWeaponCode::SHURIKEN, RangeWeaponsTable::RANGE, 14],
            [RangeWeaponCode::SHURIKEN, RangeWeaponsTable::WEIGHT, 0.1],

            [RangeWeaponCode::SPEAR, RangeWeaponsTable::REQUIRED_STRENGTH, 3],
            [RangeWeaponCode::SPEAR, RangeWeaponsTable::OFFENSIVENESS, 2],
            [RangeWeaponCode::SPEAR, RangeWeaponsTable::WOUNDS, 3],
            [RangeWeaponCode::SPEAR, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::SPEAR, RangeWeaponsTable::RANGE, 20],
            [RangeWeaponCode::SPEAR, RangeWeaponsTable::WEIGHT, 1.2],

            [RangeWeaponCode::JAVELIN, RangeWeaponsTable::REQUIRED_STRENGTH, 2],
            [RangeWeaponCode::JAVELIN, RangeWeaponsTable::OFFENSIVENESS, 2],
            [RangeWeaponCode::JAVELIN, RangeWeaponsTable::WOUNDS, 2],
            [RangeWeaponCode::JAVELIN, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::JAVELIN, RangeWeaponsTable::RANGE, 22],
            [RangeWeaponCode::JAVELIN, RangeWeaponsTable::WEIGHT, 1.0],

            [RangeWeaponCode::SLING, RangeWeaponsTable::REQUIRED_STRENGTH, -1],
            [RangeWeaponCode::SLING, RangeWeaponsTable::OFFENSIVENESS, 1],
            [RangeWeaponCode::SLING, RangeWeaponsTable::WOUNDS, 1],
            [RangeWeaponCode::SLING, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangeWeaponCode::SLING, RangeWeaponsTable::RANGE, 27],
            [RangeWeaponCode::SLING, RangeWeaponsTable::WEIGHT, 0.1],
        ];
    }

}
