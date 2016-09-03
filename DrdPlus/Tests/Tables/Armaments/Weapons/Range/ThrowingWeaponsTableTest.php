<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Codes\Armaments\RangeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTableTest;

class ThrowingWeaponsTableTest extends RangedWeaponsTableTest
{
    protected function getRowHeaderName()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangeWeaponCode::ROCK, RangedWeaponsTable::REQUIRED_STRENGTH, -2],
            [RangeWeaponCode::ROCK, RangedWeaponsTable::OFFENSIVENESS, 2],
            [RangeWeaponCode::ROCK, RangedWeaponsTable::WOUNDS, -2],
            [RangeWeaponCode::ROCK, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangeWeaponCode::ROCK, RangedWeaponsTable::RANGE, 20],
            [RangeWeaponCode::ROCK, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::ROCK, RangedWeaponsTable::WEIGHT, 0.3],

            [RangeWeaponCode::THROWING_DAGGER, RangedWeaponsTable::REQUIRED_STRENGTH, 0],
            [RangeWeaponCode::THROWING_DAGGER, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::THROWING_DAGGER, RangedWeaponsTable::WOUNDS, 1],
            [RangeWeaponCode::THROWING_DAGGER, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::THROWING_DAGGER, RangedWeaponsTable::RANGE, 14],
            [RangeWeaponCode::THROWING_DAGGER, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::THROWING_DAGGER, RangedWeaponsTable::WEIGHT, 0.2],

            [RangeWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::REQUIRED_STRENGTH, 2],
            [RangeWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::OFFENSIVENESS, 1],
            [RangeWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::WOUNDS, 2],
            [RangeWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [RangeWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::RANGE, 12],
            [RangeWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::WEIGHT, 0.7],

            [RangeWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::REQUIRED_STRENGTH, 2],
            [RangeWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::OFFENSIVENESS, 1],
            [RangeWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::WOUNDS, 5],
            [RangeWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [RangeWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::RANGE, 10],
            [RangeWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::WEIGHT, 1.0],

            [RangeWeaponCode::THROWING_HAMMER, RangedWeaponsTable::REQUIRED_STRENGTH, 5],
            [RangeWeaponCode::THROWING_HAMMER, RangedWeaponsTable::OFFENSIVENESS, 2],
            [RangeWeaponCode::THROWING_HAMMER, RangedWeaponsTable::WOUNDS, 7],
            [RangeWeaponCode::THROWING_HAMMER, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangeWeaponCode::THROWING_HAMMER, RangedWeaponsTable::RANGE, 9],
            [RangeWeaponCode::THROWING_HAMMER, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::THROWING_HAMMER, RangedWeaponsTable::WEIGHT, 1.5],

            [RangeWeaponCode::SHURIKEN, RangedWeaponsTable::REQUIRED_STRENGTH, -1],
            [RangeWeaponCode::SHURIKEN, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::SHURIKEN, RangedWeaponsTable::WOUNDS, 1],
            [RangeWeaponCode::SHURIKEN, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [RangeWeaponCode::SHURIKEN, RangedWeaponsTable::RANGE, 14],
            [RangeWeaponCode::SHURIKEN, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::SHURIKEN, RangedWeaponsTable::WEIGHT, 0.1],

            [RangeWeaponCode::SPEAR, RangedWeaponsTable::REQUIRED_STRENGTH, 3],
            [RangeWeaponCode::SPEAR, RangedWeaponsTable::OFFENSIVENESS, 2],
            [RangeWeaponCode::SPEAR, RangedWeaponsTable::WOUNDS, 3],
            [RangeWeaponCode::SPEAR, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::SPEAR, RangedWeaponsTable::RANGE, 20],
            [RangeWeaponCode::SPEAR, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::SPEAR, RangedWeaponsTable::WEIGHT, 1.2],

            [RangeWeaponCode::JAVELIN, RangedWeaponsTable::REQUIRED_STRENGTH, 2],
            [RangeWeaponCode::JAVELIN, RangedWeaponsTable::OFFENSIVENESS, 2],
            [RangeWeaponCode::JAVELIN, RangedWeaponsTable::WOUNDS, 2],
            [RangeWeaponCode::JAVELIN, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::JAVELIN, RangedWeaponsTable::RANGE, 22],
            [RangeWeaponCode::JAVELIN, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::JAVELIN, RangedWeaponsTable::WEIGHT, 1.0],

            [RangeWeaponCode::SLING, RangedWeaponsTable::REQUIRED_STRENGTH, -1],
            [RangeWeaponCode::SLING, RangedWeaponsTable::OFFENSIVENESS, 1],
            [RangeWeaponCode::SLING, RangedWeaponsTable::WOUNDS, 1],
            [RangeWeaponCode::SLING, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangeWeaponCode::SLING, RangedWeaponsTable::RANGE, 27],
            [RangeWeaponCode::SLING, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::SLING, RangedWeaponsTable::WEIGHT, 0.1],
        ];
    }

}