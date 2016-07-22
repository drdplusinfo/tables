<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\ShootingWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTableTest;

class SlingStonesTableTest extends ShootingWeaponsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [ShootingWeaponCode::SLING_STONE_LIGHT, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::SLING_STONE_LIGHT, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::SLING_STONE_LIGHT, ShootingWeaponsTable::WOUNDS, 0],
            [ShootingWeaponCode::SLING_STONE_LIGHT, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ShootingWeaponCode::SLING_STONE_LIGHT, ShootingWeaponsTable::RANGE, 0],
            [ShootingWeaponCode::SLING_STONE_LIGHT, ShootingWeaponsTable::WEIGHT, 0.1],

            [ShootingWeaponCode::SLING_STONE_HEAVIER, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::SLING_STONE_HEAVIER, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::SLING_STONE_HEAVIER, ShootingWeaponsTable::WOUNDS, 2],
            [ShootingWeaponCode::SLING_STONE_HEAVIER, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ShootingWeaponCode::SLING_STONE_HEAVIER, ShootingWeaponsTable::RANGE, -2],
            [ShootingWeaponCode::SLING_STONE_HEAVIER, ShootingWeaponsTable::WEIGHT, 0.2],
        ];
    }

}
