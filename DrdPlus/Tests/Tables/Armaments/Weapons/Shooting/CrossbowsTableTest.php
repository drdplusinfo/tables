<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\ShootingWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTableTest;

class CrossbowsTableTest extends ShootingWeaponsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [ShootingWeaponCode::MINICROSSBOW, ShootingWeaponsTable::REQUIRED_STRENGTH, -3],
            [ShootingWeaponCode::MINICROSSBOW, ShootingWeaponsTable::OFFENSIVENESS, -1],
            [ShootingWeaponCode::MINICROSSBOW, ShootingWeaponsTable::WOUNDS, 1],
            [ShootingWeaponCode::MINICROSSBOW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::MINICROSSBOW, ShootingWeaponsTable::RANGE, 19],
            [ShootingWeaponCode::MINICROSSBOW, ShootingWeaponsTable::WEIGHT, 1.0],

            [ShootingWeaponCode::LIGHT_CROSSBOW, ShootingWeaponsTable::REQUIRED_STRENGTH, 6],
            [ShootingWeaponCode::LIGHT_CROSSBOW, ShootingWeaponsTable::OFFENSIVENESS, 3],
            [ShootingWeaponCode::LIGHT_CROSSBOW, ShootingWeaponsTable::WOUNDS, 5],
            [ShootingWeaponCode::LIGHT_CROSSBOW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::LIGHT_CROSSBOW, ShootingWeaponsTable::RANGE, 36],
            [ShootingWeaponCode::LIGHT_CROSSBOW, ShootingWeaponsTable::WEIGHT, 1.5],

            [ShootingWeaponCode::MILITARY_CROSSBOW, ShootingWeaponsTable::REQUIRED_STRENGTH, 9],
            [ShootingWeaponCode::MILITARY_CROSSBOW, ShootingWeaponsTable::OFFENSIVENESS, 3],
            [ShootingWeaponCode::MILITARY_CROSSBOW, ShootingWeaponsTable::WOUNDS, 7],
            [ShootingWeaponCode::MILITARY_CROSSBOW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::MILITARY_CROSSBOW, ShootingWeaponsTable::RANGE, 40],
            [ShootingWeaponCode::MILITARY_CROSSBOW, ShootingWeaponsTable::WEIGHT, 2.0],

            [ShootingWeaponCode::HEAVY_CROSSBOW, ShootingWeaponsTable::REQUIRED_STRENGTH, 11],
            [ShootingWeaponCode::HEAVY_CROSSBOW, ShootingWeaponsTable::OFFENSIVENESS, 2],
            [ShootingWeaponCode::HEAVY_CROSSBOW, ShootingWeaponsTable::WOUNDS, 10],
            [ShootingWeaponCode::HEAVY_CROSSBOW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::HEAVY_CROSSBOW, ShootingWeaponsTable::RANGE, 38],
            [ShootingWeaponCode::HEAVY_CROSSBOW, ShootingWeaponsTable::WEIGHT, 3.0],
        ];
    }

}
