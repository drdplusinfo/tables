<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Codes\Armaments\DartCode;
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
            [DartCode::BASIC_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [DartCode::BASIC_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [DartCode::BASIC_DART, RangedWeaponsTable::WOUNDS, 0],
            [DartCode::BASIC_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [DartCode::BASIC_DART, RangedWeaponsTable::RANGE, 0],
            [DartCode::BASIC_DART, RangedWeaponsTable::COVER, 0],
            [DartCode::BASIC_DART, RangedWeaponsTable::WEIGHT, 0.05],
            [DartCode::BASIC_DART, RangedWeaponsTable::TWO_HANDED, false],

            [DartCode::WAR_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [DartCode::WAR_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [DartCode::WAR_DART, RangedWeaponsTable::WOUNDS, 2],
            [DartCode::WAR_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [DartCode::WAR_DART, RangedWeaponsTable::RANGE, -2],
            [DartCode::WAR_DART, RangedWeaponsTable::COVER, 0],
            [DartCode::WAR_DART, RangedWeaponsTable::WEIGHT, 0.1],
            [DartCode::WAR_DART, RangedWeaponsTable::TWO_HANDED, false],

            [DartCode::PIERCING_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [DartCode::PIERCING_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [DartCode::PIERCING_DART, RangedWeaponsTable::WOUNDS, -1],
            [DartCode::PIERCING_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [DartCode::PIERCING_DART, RangedWeaponsTable::RANGE, 0],
            [DartCode::PIERCING_DART, RangedWeaponsTable::COVER, 0],
            [DartCode::PIERCING_DART, RangedWeaponsTable::WEIGHT, 0.05],
            [DartCode::PIERCING_DART, RangedWeaponsTable::TWO_HANDED, false],

            [DartCode::HOLLOW_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [DartCode::HOLLOW_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [DartCode::HOLLOW_DART, RangedWeaponsTable::WOUNDS, -1],
            [DartCode::HOLLOW_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [DartCode::HOLLOW_DART, RangedWeaponsTable::RANGE, 0],
            [DartCode::HOLLOW_DART, RangedWeaponsTable::COVER, 0],
            [DartCode::HOLLOW_DART, RangedWeaponsTable::WEIGHT, 0.05],
            [DartCode::HOLLOW_DART, RangedWeaponsTable::TWO_HANDED, false],

            [DartCode::SILVER_DART, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [DartCode::SILVER_DART, RangedWeaponsTable::OFFENSIVENESS, 0],
            [DartCode::SILVER_DART, RangedWeaponsTable::WOUNDS, 0],
            [DartCode::SILVER_DART, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [DartCode::SILVER_DART, RangedWeaponsTable::RANGE, 0],
            [DartCode::SILVER_DART, RangedWeaponsTable::COVER, 0],
            [DartCode::SILVER_DART, RangedWeaponsTable::WEIGHT, 0.05],
            [DartCode::SILVER_DART, RangedWeaponsTable::TWO_HANDED, false],
        ];
    }

}