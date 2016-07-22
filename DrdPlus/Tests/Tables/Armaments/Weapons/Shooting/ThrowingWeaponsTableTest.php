<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\ShootingWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTableTest;

class ThrowingWeaponsTableTest extends ShootingWeaponsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [ShootingWeaponCode::ROCK, ShootingWeaponsTable::REQUIRED_STRENGTH, -2],
            [ShootingWeaponCode::ROCK, ShootingWeaponsTable::OFFENSIVENESS, 2],
            [ShootingWeaponCode::ROCK, ShootingWeaponsTable::WOUNDS, -2],
            [ShootingWeaponCode::ROCK, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ShootingWeaponCode::ROCK, ShootingWeaponsTable::RANGE, 20],
            [ShootingWeaponCode::ROCK, ShootingWeaponsTable::WEIGHT, 0.3],

            [ShootingWeaponCode::THROWING_DAGGER, ShootingWeaponsTable::REQUIRED_STRENGTH, 0],
            [ShootingWeaponCode::THROWING_DAGGER, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::THROWING_DAGGER, ShootingWeaponsTable::WOUNDS, 1],
            [ShootingWeaponCode::THROWING_DAGGER, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::THROWING_DAGGER, ShootingWeaponsTable::RANGE, 14],
            [ShootingWeaponCode::THROWING_DAGGER, ShootingWeaponsTable::WEIGHT, 0.2],

            [ShootingWeaponCode::LIGHT_THROWING_AXE, ShootingWeaponsTable::REQUIRED_STRENGTH, 2],
            [ShootingWeaponCode::LIGHT_THROWING_AXE, ShootingWeaponsTable::OFFENSIVENESS, 1],
            [ShootingWeaponCode::LIGHT_THROWING_AXE, ShootingWeaponsTable::WOUNDS, 2],
            [ShootingWeaponCode::LIGHT_THROWING_AXE, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [ShootingWeaponCode::LIGHT_THROWING_AXE, ShootingWeaponsTable::RANGE, 12],
            [ShootingWeaponCode::LIGHT_THROWING_AXE, ShootingWeaponsTable::WEIGHT, 0.7],

            [ShootingWeaponCode::WAR_THROWING_AXE, ShootingWeaponsTable::REQUIRED_STRENGTH, 2],
            [ShootingWeaponCode::WAR_THROWING_AXE, ShootingWeaponsTable::OFFENSIVENESS, 1],
            [ShootingWeaponCode::WAR_THROWING_AXE, ShootingWeaponsTable::WOUNDS, 5],
            [ShootingWeaponCode::WAR_THROWING_AXE, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [ShootingWeaponCode::WAR_THROWING_AXE, ShootingWeaponsTable::RANGE, 10],
            [ShootingWeaponCode::WAR_THROWING_AXE, ShootingWeaponsTable::WEIGHT, 1.0],

            [ShootingWeaponCode::THROWING_HAMMER, ShootingWeaponsTable::REQUIRED_STRENGTH, 5],
            [ShootingWeaponCode::THROWING_HAMMER, ShootingWeaponsTable::OFFENSIVENESS, 2],
            [ShootingWeaponCode::THROWING_HAMMER, ShootingWeaponsTable::WOUNDS, 7],
            [ShootingWeaponCode::THROWING_HAMMER, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ShootingWeaponCode::THROWING_HAMMER, ShootingWeaponsTable::RANGE, 9],
            [ShootingWeaponCode::THROWING_HAMMER, ShootingWeaponsTable::WEIGHT, 1.5],

            [ShootingWeaponCode::SHURIKEN, ShootingWeaponsTable::REQUIRED_STRENGTH, -1],
            [ShootingWeaponCode::SHURIKEN, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::SHURIKEN, ShootingWeaponsTable::WOUNDS, 1],
            [ShootingWeaponCode::SHURIKEN, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [ShootingWeaponCode::SHURIKEN, ShootingWeaponsTable::RANGE, 14],
            [ShootingWeaponCode::SHURIKEN, ShootingWeaponsTable::WEIGHT, 0.1],

            [ShootingWeaponCode::SPEAR, ShootingWeaponsTable::REQUIRED_STRENGTH, 3],
            [ShootingWeaponCode::SPEAR, ShootingWeaponsTable::OFFENSIVENESS, 2],
            [ShootingWeaponCode::SPEAR, ShootingWeaponsTable::WOUNDS, 3],
            [ShootingWeaponCode::SPEAR, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::SPEAR, ShootingWeaponsTable::RANGE, 20],
            [ShootingWeaponCode::SPEAR, ShootingWeaponsTable::WEIGHT, 1.2],

            [ShootingWeaponCode::JAVELIN, ShootingWeaponsTable::REQUIRED_STRENGTH, 2],
            [ShootingWeaponCode::JAVELIN, ShootingWeaponsTable::OFFENSIVENESS, 2],
            [ShootingWeaponCode::JAVELIN, ShootingWeaponsTable::WOUNDS, 2],
            [ShootingWeaponCode::JAVELIN, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::JAVELIN, ShootingWeaponsTable::RANGE, 22],
            [ShootingWeaponCode::JAVELIN, ShootingWeaponsTable::WEIGHT, 1.0],

            [ShootingWeaponCode::SLING, ShootingWeaponsTable::REQUIRED_STRENGTH, -1],
            [ShootingWeaponCode::SLING, ShootingWeaponsTable::OFFENSIVENESS, 1],
            [ShootingWeaponCode::SLING, ShootingWeaponsTable::WOUNDS, 1],
            [ShootingWeaponCode::SLING, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ShootingWeaponCode::SLING, ShootingWeaponsTable::RANGE, 27],
            [ShootingWeaponCode::SLING, ShootingWeaponsTable::WEIGHT, 0.1],
        ];
    }

}
