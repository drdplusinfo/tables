<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTableTest;

class DartsTableTest extends RangedWeaponsTableTest
{
    protected function getRowHeaderName()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangedWeaponCode::BASIC_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::BASIC_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::BASIC_DART, RangedWeaponsTable::WOUNDS, 0],
            [RangedWeaponCode::BASIC_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::BASIC_DART, RangedWeaponsTable::RANGE, 0],
            [RangedWeaponCode::BASIC_DART, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::BASIC_DART, RangedWeaponsTable::WEIGHT, 0.05],

            [RangedWeaponCode::WAR_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::WAR_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::WAR_DART, RangedWeaponsTable::WOUNDS, 2],
            [RangedWeaponCode::WAR_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::WAR_DART, RangedWeaponsTable::RANGE, -2],
            [RangedWeaponCode::WAR_DART, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::WAR_DART, RangedWeaponsTable::WEIGHT, 0.1],

            [RangedWeaponCode::PIERCING_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::PIERCING_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::PIERCING_DART, RangedWeaponsTable::WOUNDS, -1],
            [RangedWeaponCode::PIERCING_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::PIERCING_DART, RangedWeaponsTable::RANGE, 0],
            [RangedWeaponCode::PIERCING_DART, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::PIERCING_DART, RangedWeaponsTable::WEIGHT, 0.05],

            [RangedWeaponCode::HOLLOW_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::HOLLOW_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::HOLLOW_DART, RangedWeaponsTable::WOUNDS, -1],
            [RangedWeaponCode::HOLLOW_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::HOLLOW_DART, RangedWeaponsTable::RANGE, 0],
            [RangedWeaponCode::HOLLOW_DART, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::HOLLOW_DART, RangedWeaponsTable::WEIGHT, 0.05],

            [RangedWeaponCode::SILVER_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::SILVER_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::SILVER_DART, RangedWeaponsTable::WOUNDS, 0],
            [RangedWeaponCode::SILVER_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::SILVER_DART, RangedWeaponsTable::RANGE, 0],
            [RangedWeaponCode::SILVER_DART, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::SILVER_DART, RangedWeaponsTable::WEIGHT, 0.05],
        ];
    }

}