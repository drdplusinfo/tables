<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Codes\Armaments\RangeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTableTest;

class CrossbowsTableTest extends RangeWeaponsTableTest
{
    protected function getRowHeaderName()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangeWeaponCode::MINICROSSBOW, RangeWeaponsTable::REQUIRED_STRENGTH, -3],
            [RangeWeaponCode::MINICROSSBOW, RangeWeaponsTable::OFFENSIVENESS, -1],
            [RangeWeaponCode::MINICROSSBOW, RangeWeaponsTable::WOUNDS, 1],
            [RangeWeaponCode::MINICROSSBOW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::MINICROSSBOW, RangeWeaponsTable::RANGE, 19],
            [RangeWeaponCode::MINICROSSBOW, RangeWeaponsTable::WEIGHT, 1.0],

            [RangeWeaponCode::LIGHT_CROSSBOW, RangeWeaponsTable::REQUIRED_STRENGTH, 6],
            [RangeWeaponCode::LIGHT_CROSSBOW, RangeWeaponsTable::OFFENSIVENESS, 3],
            [RangeWeaponCode::LIGHT_CROSSBOW, RangeWeaponsTable::WOUNDS, 5],
            [RangeWeaponCode::LIGHT_CROSSBOW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::LIGHT_CROSSBOW, RangeWeaponsTable::RANGE, 36],
            [RangeWeaponCode::LIGHT_CROSSBOW, RangeWeaponsTable::WEIGHT, 1.5],

            [RangeWeaponCode::MILITARY_CROSSBOW, RangeWeaponsTable::REQUIRED_STRENGTH, 9],
            [RangeWeaponCode::MILITARY_CROSSBOW, RangeWeaponsTable::OFFENSIVENESS, 3],
            [RangeWeaponCode::MILITARY_CROSSBOW, RangeWeaponsTable::WOUNDS, 7],
            [RangeWeaponCode::MILITARY_CROSSBOW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::MILITARY_CROSSBOW, RangeWeaponsTable::RANGE, 40],
            [RangeWeaponCode::MILITARY_CROSSBOW, RangeWeaponsTable::WEIGHT, 2.0],

            [RangeWeaponCode::HEAVY_CROSSBOW, RangeWeaponsTable::REQUIRED_STRENGTH, 11],
            [RangeWeaponCode::HEAVY_CROSSBOW, RangeWeaponsTable::OFFENSIVENESS, 2],
            [RangeWeaponCode::HEAVY_CROSSBOW, RangeWeaponsTable::WOUNDS, 10],
            [RangeWeaponCode::HEAVY_CROSSBOW, RangeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::HEAVY_CROSSBOW, RangeWeaponsTable::RANGE, 38],
            [RangeWeaponCode::HEAVY_CROSSBOW, RangeWeaponsTable::WEIGHT, 3.0],
        ];
    }

}
