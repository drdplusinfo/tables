<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\Body\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTableTest;

class CrossbowsTableTest extends RangedWeaponsTableTest
{
    protected function getRowHeaderName(): string
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue(): array
    {
        return [
            [RangedWeaponCode::MINICROSSBOW, RangedWeaponsTable::REQUIRED_STRENGTH, -3],
            [RangedWeaponCode::MINICROSSBOW, RangedWeaponsTable::OFFENSIVENESS, -1],
            [RangedWeaponCode::MINICROSSBOW, RangedWeaponsTable::WOUNDS, 1],
            [RangedWeaponCode::MINICROSSBOW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::MINICROSSBOW, RangedWeaponsTable::RANGE, 19],
            [RangedWeaponCode::MINICROSSBOW, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::MINICROSSBOW, RangedWeaponsTable::WEIGHT, 1.0],
            [RangedWeaponCode::MINICROSSBOW, RangedWeaponsTable::TWO_HANDED, false],

            [RangedWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::REQUIRED_STRENGTH, 6],
            [RangedWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::OFFENSIVENESS, 3],
            [RangedWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::WOUNDS, 5],
            [RangedWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::RANGE, 36],
            [RangedWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::WEIGHT, 1.5],
            [RangedWeaponCode::LIGHT_CROSSBOW, RangedWeaponsTable::TWO_HANDED, true],

            [RangedWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::REQUIRED_STRENGTH, 9],
            [RangedWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::OFFENSIVENESS, 3],
            [RangedWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::WOUNDS, 7],
            [RangedWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::RANGE, 40],
            [RangedWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::WEIGHT, 2.0],
            [RangedWeaponCode::MILITARY_CROSSBOW, RangedWeaponsTable::TWO_HANDED, true],

            [RangedWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::REQUIRED_STRENGTH, 11],
            [RangedWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::OFFENSIVENESS, 2],
            [RangedWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::WOUNDS, 10],
            [RangedWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::RANGE, 38],
            [RangedWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::COVER, 2],
            [RangedWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::WEIGHT, 3.0],
            [RangedWeaponCode::HEAVY_CROSSBOW, RangedWeaponsTable::TWO_HANDED, true],
        ];
    }

}