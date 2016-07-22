<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Codes\ShootingWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTableTest;

class BowsTableTest extends ShootingWeaponsTableTest
{
    protected function getRowHeaderValue()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [ShootingWeaponCode::SHORT_BOW, ShootingWeaponsTable::REQUIRED_STRENGTH, [-1, 3]],
            [ShootingWeaponCode::SHORT_BOW, ShootingWeaponsTable::OFFENSIVENESS, 2],
            [ShootingWeaponCode::SHORT_BOW, ShootingWeaponsTable::WOUNDS, 1],
            [ShootingWeaponCode::SHORT_BOW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::SHORT_BOW, ShootingWeaponsTable::RANGE, 24],
            [ShootingWeaponCode::SHORT_BOW, ShootingWeaponsTable::WEIGHT, 1.0],

            [ShootingWeaponCode::LONG_BOW, ShootingWeaponsTable::REQUIRED_STRENGTH, [5, 7]],
            [ShootingWeaponCode::LONG_BOW, ShootingWeaponsTable::OFFENSIVENESS, 3],
            [ShootingWeaponCode::LONG_BOW, ShootingWeaponsTable::WOUNDS, 4],
            [ShootingWeaponCode::LONG_BOW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::LONG_BOW, ShootingWeaponsTable::RANGE, 27],
            [ShootingWeaponCode::LONG_BOW, ShootingWeaponsTable::WEIGHT, 1.2],

            [ShootingWeaponCode::SHORT_COMPOSITE_BOW, ShootingWeaponsTable::REQUIRED_STRENGTH, [1, 6]],
            [ShootingWeaponCode::SHORT_COMPOSITE_BOW, ShootingWeaponsTable::OFFENSIVENESS, 3],
            [ShootingWeaponCode::SHORT_COMPOSITE_BOW, ShootingWeaponsTable::WOUNDS, 2],
            [ShootingWeaponCode::SHORT_COMPOSITE_BOW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::SHORT_COMPOSITE_BOW, ShootingWeaponsTable::RANGE, 26],
            [ShootingWeaponCode::SHORT_COMPOSITE_BOW, ShootingWeaponsTable::WEIGHT, 1.0],

            [ShootingWeaponCode::LONG_COMPOSITE_BOW, ShootingWeaponsTable::REQUIRED_STRENGTH, [5, 9]],
            [ShootingWeaponCode::LONG_COMPOSITE_BOW, ShootingWeaponsTable::OFFENSIVENESS, 4],
            [ShootingWeaponCode::LONG_COMPOSITE_BOW, ShootingWeaponsTable::WOUNDS, 5],
            [ShootingWeaponCode::LONG_COMPOSITE_BOW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::LONG_COMPOSITE_BOW, ShootingWeaponsTable::RANGE, 29],
            [ShootingWeaponCode::LONG_COMPOSITE_BOW, ShootingWeaponsTable::WEIGHT, 1.5],

            [ShootingWeaponCode::POWER_BOW, ShootingWeaponsTable::REQUIRED_STRENGTH, [7, 12]],
            [ShootingWeaponCode::POWER_BOW, ShootingWeaponsTable::OFFENSIVENESS, 5],
            [ShootingWeaponCode::POWER_BOW, ShootingWeaponsTable::WOUNDS, 6],
            [ShootingWeaponCode::POWER_BOW, ShootingWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ShootingWeaponCode::POWER_BOW, ShootingWeaponsTable::RANGE, 31],
            [ShootingWeaponCode::POWER_BOW, ShootingWeaponsTable::WEIGHT, 2.0],
        ];
    }

}
