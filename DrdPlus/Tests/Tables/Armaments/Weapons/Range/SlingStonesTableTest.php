<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Codes\Armaments\RangeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTableTest;

class SlingStonesTableTest extends RangedWeaponsTableTest
{
    protected function getRowHeaderName()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangeWeaponCode::SLING_STONE_LIGHT, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::SLING_STONE_LIGHT, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::SLING_STONE_LIGHT, RangedWeaponsTable::WOUNDS, 0],
            [RangeWeaponCode::SLING_STONE_LIGHT, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangeWeaponCode::SLING_STONE_LIGHT, RangedWeaponsTable::RANGE, 0],
            [RangeWeaponCode::SLING_STONE_LIGHT, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::SLING_STONE_LIGHT, RangedWeaponsTable::WEIGHT, 0.1],

            [RangeWeaponCode::SLING_STONE_HEAVIER, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangeWeaponCode::SLING_STONE_HEAVIER, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangeWeaponCode::SLING_STONE_HEAVIER, RangedWeaponsTable::WOUNDS, 2],
            [RangeWeaponCode::SLING_STONE_HEAVIER, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangeWeaponCode::SLING_STONE_HEAVIER, RangedWeaponsTable::RANGE, -2],
            [RangeWeaponCode::SLING_STONE_HEAVIER, RangedWeaponsTable::COVER, 0],
            [RangeWeaponCode::SLING_STONE_HEAVIER, RangedWeaponsTable::WEIGHT, 0.2],
        ];
    }

}