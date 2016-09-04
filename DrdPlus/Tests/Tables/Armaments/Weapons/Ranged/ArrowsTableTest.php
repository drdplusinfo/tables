<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTableTest;

class ArrowsTableTest extends RangedWeaponsTableTest
{
    protected function getRowHeaderName()
    {
        return 'projectile';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangedWeaponCode::BASIC_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::BASIC_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::BASIC_ARROW, RangedWeaponsTable::WOUNDS, 0],
            [RangedWeaponCode::BASIC_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::BASIC_ARROW, RangedWeaponsTable::RANGE, 0],
            [RangedWeaponCode::BASIC_ARROW, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::BASIC_ARROW, RangedWeaponsTable::WEIGHT, 0.05],

            [RangedWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::WOUNDS, -1],
            [RangedWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::RANGE, 2],
            [RangedWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::LONG_RANGE_ARROW, RangedWeaponsTable::WEIGHT, 0.05],

            [RangedWeaponCode::WAR_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::WAR_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::WAR_ARROW, RangedWeaponsTable::WOUNDS, 2],
            [RangedWeaponCode::WAR_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::WAR_ARROW, RangedWeaponsTable::RANGE, -2],
            [RangedWeaponCode::WAR_ARROW, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::WAR_ARROW, RangedWeaponsTable::WEIGHT, 0.1],

            [RangedWeaponCode::PIERCING_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::PIERCING_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::PIERCING_ARROW, RangedWeaponsTable::WOUNDS, -1],
            [RangedWeaponCode::PIERCING_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::PIERCING_ARROW, RangedWeaponsTable::RANGE, 0],
            [RangedWeaponCode::PIERCING_ARROW, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::PIERCING_ARROW, RangedWeaponsTable::WEIGHT, 0.05],

            [RangedWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::WOUNDS, -1],
            [RangedWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::RANGE, 0],
            [RangedWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::HOLLOW_ARROW, RangedWeaponsTable::WEIGHT, 0.05],

            [RangedWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::OFFENSIVENESS, -1],
            [RangedWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::WOUNDS, -2],
            [RangedWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::RANGE, -1],
            [RangedWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::CRIPPLING_ARROW, RangedWeaponsTable::WEIGHT, 0.05],

            [RangedWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::OFFENSIVENESS, -3],
            [RangedWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::WOUNDS, -3],
            [RangedWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [RangedWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::RANGE, -2],
            [RangedWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::INCENDIARY_ARROW, RangedWeaponsTable::WEIGHT, 0.05],

            [RangedWeaponCode::SILVER_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [RangedWeaponCode::SILVER_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [RangedWeaponCode::SILVER_ARROW, RangedWeaponsTable::WOUNDS, 0],
            [RangedWeaponCode::SILVER_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::SILVER_ARROW, RangedWeaponsTable::RANGE, 0],
            [RangedWeaponCode::SILVER_ARROW, RangedWeaponsTable::COVER, 0],
            [RangedWeaponCode::SILVER_ARROW, RangedWeaponsTable::WEIGHT, 0.05],
        ];
    }

}