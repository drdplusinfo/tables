<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Codes\Armaments\RangeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials\RangedWeaponsTableTest;

class CrossbowsTableTest extends RangedWeaponsTableTest
{
    protected function getRowHeaderName()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangeWeaponCode::MINICROSSBOW, RangedWeaponsTable::REQUIRED_STRENGTH, -3],
            [RangeWeaponCode::MINICROSSBOW, RangedWeaponsTable::OFFENSIVENESS, -1],
            [RangeWeaponCode::MINICROSSBOW, RangedWeaponsTable::WOUNDS, 1],
            [RangeWeaponCode::MINICROSSBOW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::MINICROSSBOW, RangedWeaponsTable::RANGE, 19],
            [RangeWeaponCode::MINICROSSBOW, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::MINICROSSBOW, RangedWeaponsTable::WEIGHT, 1.0],

            [RangeWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::REQUIRED_STRENGTH, 6],
            [RangeWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::OFFENSIVENESS, 3],
            [RangeWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::WOUNDS, 5],
            [RangeWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::RANGE, 36],
            [RangeWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::WEIGHT, 1.5],

            [RangeWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::REQUIRED_STRENGTH, 9],
            [RangeWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::OFFENSIVENESS, 3],
            [RangeWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::WOUNDS, 7],
            [RangeWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::RANGE, 40],
            [RangeWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::WEIGHT, 2.0],

            [RangeWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::REQUIRED_STRENGTH, 11],
            [RangeWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::OFFENSIVENESS, 2],
            [RangeWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::WOUNDS, 10],
            [RangeWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::RANGE, 38],
            [RangeWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::COVER, 2],
            [RangeWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::WEIGHT, 3.0],
        ];
    }

}