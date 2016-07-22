<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\ShootingWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTableTest;

class DartsTableTest extends ShootingWeaponsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [ShootingWeaponCode::BASIC_DART, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::BASIC_DART, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::BASIC_DART, ShootingWeaponsTable::WOUNDS, 0],
            [ShootingWeaponCode::BASIC_DART, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::BASIC_DART, ShootingWeaponsTable::RANGE, 0],
            [ShootingWeaponCode::BASIC_DART, ShootingWeaponsTable::WEIGHT, 0.05],

            [ShootingWeaponCode::WAR_DART, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::WAR_DART, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::WAR_DART, ShootingWeaponsTable::WOUNDS, 2],
            [ShootingWeaponCode::WAR_DART, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::WAR_DART, ShootingWeaponsTable::RANGE, -2],
            [ShootingWeaponCode::WAR_DART, ShootingWeaponsTable::WEIGHT, 0.1],

            [ShootingWeaponCode::PIERCING_DART, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::PIERCING_DART, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::PIERCING_DART, ShootingWeaponsTable::WOUNDS, -1],
            [ShootingWeaponCode::PIERCING_DART, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::PIERCING_DART, ShootingWeaponsTable::RANGE, 0],
            [ShootingWeaponCode::PIERCING_DART, ShootingWeaponsTable::WEIGHT, 0.05],

            [ShootingWeaponCode::HOLLOW_DART, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::HOLLOW_DART, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::HOLLOW_DART, ShootingWeaponsTable::WOUNDS, -1],
            [ShootingWeaponCode::HOLLOW_DART, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::HOLLOW_DART, ShootingWeaponsTable::RANGE, 0],
            [ShootingWeaponCode::HOLLOW_DART, ShootingWeaponsTable::WEIGHT, 0.05],

            [ShootingWeaponCode::SILVER_DART, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::SILVER_DART, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::SILVER_DART, ShootingWeaponsTable::WOUNDS, 0],
            [ShootingWeaponCode::SILVER_DART, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::SILVER_DART, ShootingWeaponsTable::RANGE, 0],
            [ShootingWeaponCode::SILVER_DART, ShootingWeaponsTable::WEIGHT, 0.05],
        ];
    }

}
