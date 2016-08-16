<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTableTest;

class SlingStonesTableTest extends RangeWeaponsTableTest
{
    protected function getRowHeaderName()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangeWeaponCode::SLING_STONE_LIGHT, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::SLING_STONE_LIGHT, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::SLING_STONE_LIGHT, RangeWeaponsTable::WOUNDS, 0],
            [RangeWeaponCode::SLING_STONE_LIGHT, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangeWeaponCode::SLING_STONE_LIGHT, RangeWeaponsTable::RANGE, 0],
            [RangeWeaponCode::SLING_STONE_LIGHT, RangeWeaponsTable::WEIGHT, 0.1],

            [RangeWeaponCode::SLING_STONE_HEAVIER, RangeWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::SLING_STONE_HEAVIER, RangeWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::SLING_STONE_HEAVIER, RangeWeaponsTable::WOUNDS, 2],
            [RangeWeaponCode::SLING_STONE_HEAVIER, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangeWeaponCode::SLING_STONE_HEAVIER, RangeWeaponsTable::RANGE, -2],
            [RangeWeaponCode::SLING_STONE_HEAVIER, RangeWeaponsTable::WEIGHT, 0.2],
        ];
    }

}
