<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTableTest;

class ThrowingWeaponsTableTest extends RangedWeaponsTableTest
{
    protected function getRowHeaderName()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue(): array
    {
        return [
            [RangedWeaponCode::ROCK, RangedWeaponsTable::REQUIRED_STRENGTH, -2],
            [RangedWeaponCode::ROCK, RangedWeaponsTable::OFFENSIVENESS, 2],
            [RangedWeaponCode::ROCK, RangedWeaponsTable::WOUNDS, -2],
            [RangedWeaponCode::ROCK, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangedWeaponCode::ROCK, RangedWeaponsTable::RANGE, 20],
            [RangedWeaponCode::ROCK, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::ROCK, RangedWeaponsTable::WEIGHT, 0.3],
            [RangedWeaponCode::ROCK, RangedWeaponsTable::TWO_HANDED, false],

            [RangedWeaponCode::THROWING_DAGGER, RangedWeaponsTable::REQUIRED_STRENGTH, 0],
            [RangedWeaponCode::THROWING_DAGGER, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::THROWING_DAGGER, RangedWeaponsTable::WOUNDS, 1],
            [RangedWeaponCode::THROWING_DAGGER, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::THROWING_DAGGER, RangedWeaponsTable::RANGE, 14],
            [RangedWeaponCode::THROWING_DAGGER, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::THROWING_DAGGER, RangedWeaponsTable::WEIGHT, 0.2],
            [RangedWeaponCode::THROWING_DAGGER, RangedWeaponsTable::TWO_HANDED, false],

            [RangedWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::REQUIRED_STRENGTH, 2],
            [RangedWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::OFFENSIVENESS, 1],
            [RangedWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::WOUNDS, 2],
            [RangedWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [RangedWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::RANGE, 12],
            [RangedWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::WEIGHT, 0.7],
            [RangedWeaponCode::LIGHT_THROWING_AXE, RangedWeaponsTable::TWO_HANDED, false],

            [RangedWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::REQUIRED_STRENGTH, 2],
            [RangedWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::OFFENSIVENESS, 1],
            [RangedWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::WOUNDS, 5],
            [RangedWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [RangedWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::RANGE, 10],
            [RangedWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::WEIGHT, 1.0],
            [RangedWeaponCode::WAR_THROWING_AXE, RangedWeaponsTable::TWO_HANDED, false],

            [RangedWeaponCode::THROWING_HAMMER, RangedWeaponsTable::REQUIRED_STRENGTH, 5],
            [RangedWeaponCode::THROWING_HAMMER, RangedWeaponsTable::OFFENSIVENESS, 2],
            [RangedWeaponCode::THROWING_HAMMER, RangedWeaponsTable::WOUNDS, 7],
            [RangedWeaponCode::THROWING_HAMMER, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangedWeaponCode::THROWING_HAMMER, RangedWeaponsTable::RANGE, 9],
            [RangedWeaponCode::THROWING_HAMMER, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::THROWING_HAMMER, RangedWeaponsTable::WEIGHT, 1.5],
            [RangedWeaponCode::THROWING_HAMMER, RangedWeaponsTable::TWO_HANDED, false],

            [RangedWeaponCode::SHURIKEN, RangedWeaponsTable::REQUIRED_STRENGTH, -1],
            [RangedWeaponCode::SHURIKEN, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::SHURIKEN, RangedWeaponsTable::WOUNDS, 1],
            [RangedWeaponCode::SHURIKEN, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [RangedWeaponCode::SHURIKEN, RangedWeaponsTable::RANGE, 14],
            [RangedWeaponCode::SHURIKEN, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::SHURIKEN, RangedWeaponsTable::WEIGHT, 0.1],
            [RangedWeaponCode::SHURIKEN, RangedWeaponsTable::TWO_HANDED, false],

            [RangedWeaponCode::SPEAR, RangedWeaponsTable::REQUIRED_STRENGTH, 3],
            [RangedWeaponCode::SPEAR, RangedWeaponsTable::OFFENSIVENESS, 2],
            [RangedWeaponCode::SPEAR, RangedWeaponsTable::WOUNDS, 3],
            [RangedWeaponCode::SPEAR, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::SPEAR, RangedWeaponsTable::RANGE, 20],
            [RangedWeaponCode::SPEAR, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::SPEAR, RangedWeaponsTable::WEIGHT, 1.2],
            [RangedWeaponCode::SPEAR, RangedWeaponsTable::TWO_HANDED, true],

            [RangedWeaponCode::JAVELIN, RangedWeaponsTable::REQUIRED_STRENGTH, 2],
            [RangedWeaponCode::JAVELIN, RangedWeaponsTable::OFFENSIVENESS, 2],
            [RangedWeaponCode::JAVELIN, RangedWeaponsTable::WOUNDS, 2],
            [RangedWeaponCode::JAVELIN, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::JAVELIN, RangedWeaponsTable::RANGE, 22],
            [RangedWeaponCode::JAVELIN, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::JAVELIN, RangedWeaponsTable::WEIGHT, 1.0],
            [RangedWeaponCode::JAVELIN, RangedWeaponsTable::TWO_HANDED, false],

            [RangedWeaponCode::SLING, RangedWeaponsTable::REQUIRED_STRENGTH, -1],
            [RangedWeaponCode::SLING, RangedWeaponsTable::OFFENSIVENESS, 1],
            [RangedWeaponCode::SLING, RangedWeaponsTable::WOUNDS, 1],
            [RangedWeaponCode::SLING, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangedWeaponCode::SLING, RangedWeaponsTable::RANGE, 27],
            [RangedWeaponCode::SLING, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::SLING, RangedWeaponsTable::WEIGHT, 0.1],
            [RangedWeaponCode::SLING, RangedWeaponsTable::TWO_HANDED, false],
        ];
    }

}