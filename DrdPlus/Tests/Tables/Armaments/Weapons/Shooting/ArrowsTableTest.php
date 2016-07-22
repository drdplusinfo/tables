<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\ShootingWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTableTest;

class ArrowsTableTest extends ShootingWeaponsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [ShootingWeaponCode::BASIC_ARROW, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::BASIC_ARROW, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::BASIC_ARROW, ShootingWeaponsTable::WOUNDS, 0],
            [ShootingWeaponCode::BASIC_ARROW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::BASIC_ARROW, ShootingWeaponsTable::RANGE, 0],
            [ShootingWeaponCode::BASIC_ARROW, ShootingWeaponsTable::WEIGHT, 0.05],

            [ShootingWeaponCode::LONG_RANGE_ARROW, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::LONG_RANGE_ARROW, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::LONG_RANGE_ARROW, ShootingWeaponsTable::WOUNDS, -1],
            [ShootingWeaponCode::LONG_RANGE_ARROW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::LONG_RANGE_ARROW, ShootingWeaponsTable::RANGE, 2],
            [ShootingWeaponCode::LONG_RANGE_ARROW, ShootingWeaponsTable::WEIGHT, 0.05],

            [ShootingWeaponCode::WAR_ARROW, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::WAR_ARROW, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::WAR_ARROW, ShootingWeaponsTable::WOUNDS, 2],
            [ShootingWeaponCode::WAR_ARROW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::WAR_ARROW, ShootingWeaponsTable::RANGE, -2],
            [ShootingWeaponCode::WAR_ARROW, ShootingWeaponsTable::WEIGHT, 0.1],

            [ShootingWeaponCode::PIERCING_ARROW, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::PIERCING_ARROW, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::PIERCING_ARROW, ShootingWeaponsTable::WOUNDS, -1],
            [ShootingWeaponCode::PIERCING_ARROW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::PIERCING_ARROW, ShootingWeaponsTable::RANGE, 0],
            [ShootingWeaponCode::PIERCING_ARROW, ShootingWeaponsTable::WEIGHT, 0.05],

            [ShootingWeaponCode::HOLLOW_ARROW, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::HOLLOW_ARROW, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::HOLLOW_ARROW, ShootingWeaponsTable::WOUNDS, -1],
            [ShootingWeaponCode::HOLLOW_ARROW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::HOLLOW_ARROW, ShootingWeaponsTable::RANGE, 0],
            [ShootingWeaponCode::HOLLOW_ARROW, ShootingWeaponsTable::WEIGHT, 0.05],

            [ShootingWeaponCode::CRIPPLING_ARROW, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::CRIPPLING_ARROW, ShootingWeaponsTable::OFFENSIVENESS, -1],
            [ShootingWeaponCode::CRIPPLING_ARROW, ShootingWeaponsTable::WOUNDS, -2],
            [ShootingWeaponCode::CRIPPLING_ARROW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::CRIPPLING_ARROW, ShootingWeaponsTable::RANGE, -1],
            [ShootingWeaponCode::CRIPPLING_ARROW, ShootingWeaponsTable::WEIGHT, 0.05],

            [ShootingWeaponCode::INCENDIARY_ARROW, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::INCENDIARY_ARROW, ShootingWeaponsTable::OFFENSIVENESS, -3],
            [ShootingWeaponCode::INCENDIARY_ARROW, ShootingWeaponsTable::WOUNDS, -3],
            [ShootingWeaponCode::INCENDIARY_ARROW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ShootingWeaponCode::INCENDIARY_ARROW, ShootingWeaponsTable::RANGE, -2],
            [ShootingWeaponCode::INCENDIARY_ARROW, ShootingWeaponsTable::WEIGHT, 0.05],

            [ShootingWeaponCode::SILVER_ARROW, ShootingWeaponsTable::REQUIRED_STRENGTH, false],
            [ShootingWeaponCode::SILVER_ARROW, ShootingWeaponsTable::OFFENSIVENESS, 0],
            [ShootingWeaponCode::SILVER_ARROW, ShootingWeaponsTable::WOUNDS, 0],
            [ShootingWeaponCode::SILVER_ARROW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::SILVER_ARROW, ShootingWeaponsTable::RANGE, 0],
            [ShootingWeaponCode::SILVER_ARROW, ShootingWeaponsTable::WEIGHT, 0.05],
        ];
    }

}
