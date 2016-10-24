<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Codes\Armaments\ArrowCode;
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
            [ArrowCode::BASIC_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [ArrowCode::BASIC_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [ArrowCode::BASIC_ARROW, RangedWeaponsTable::WOUNDS, 0],
            [ArrowCode::BASIC_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::BASIC_ARROW, RangedWeaponsTable::RANGE, 0],
            [ArrowCode::BASIC_ARROW, RangedWeaponsTable::COVER, 0],
            [ArrowCode::BASIC_ARROW, RangedWeaponsTable::WEIGHT, 0.05],
            [ArrowCode::BASIC_ARROW, RangedWeaponsTable::TWO_HANDED, false],

            [ArrowCode::LONG_RANGE_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [ArrowCode::LONG_RANGE_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [ArrowCode::LONG_RANGE_ARROW, RangedWeaponsTable::WOUNDS, -1],
            [ArrowCode::LONG_RANGE_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::LONG_RANGE_ARROW, RangedWeaponsTable::RANGE, 2],
            [ArrowCode::LONG_RANGE_ARROW, RangedWeaponsTable::COVER, 0],
            [ArrowCode::LONG_RANGE_ARROW, RangedWeaponsTable::WEIGHT, 0.05],
            [ArrowCode::LONG_RANGE_ARROW, RangedWeaponsTable::TWO_HANDED, false],

            [ArrowCode::WAR_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [ArrowCode::WAR_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [ArrowCode::WAR_ARROW, RangedWeaponsTable::WOUNDS, 2],
            [ArrowCode::WAR_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::WAR_ARROW, RangedWeaponsTable::RANGE, -2],
            [ArrowCode::WAR_ARROW, RangedWeaponsTable::COVER, 0],
            [ArrowCode::WAR_ARROW, RangedWeaponsTable::WEIGHT, 0.1],
            [ArrowCode::WAR_ARROW, RangedWeaponsTable::TWO_HANDED, false],

            [ArrowCode::PIERCING_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [ArrowCode::PIERCING_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [ArrowCode::PIERCING_ARROW, RangedWeaponsTable::WOUNDS, -1],
            [ArrowCode::PIERCING_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::PIERCING_ARROW, RangedWeaponsTable::RANGE, 0],
            [ArrowCode::PIERCING_ARROW, RangedWeaponsTable::COVER, 0],
            [ArrowCode::PIERCING_ARROW, RangedWeaponsTable::WEIGHT, 0.05],
            [ArrowCode::PIERCING_ARROW, RangedWeaponsTable::TWO_HANDED, false],

            [ArrowCode::HOLLOW_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [ArrowCode::HOLLOW_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [ArrowCode::HOLLOW_ARROW, RangedWeaponsTable::WOUNDS, -1],
            [ArrowCode::HOLLOW_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::HOLLOW_ARROW, RangedWeaponsTable::RANGE, 0],
            [ArrowCode::HOLLOW_ARROW, RangedWeaponsTable::COVER, 0],
            [ArrowCode::HOLLOW_ARROW, RangedWeaponsTable::WEIGHT, 0.05],
            [ArrowCode::HOLLOW_ARROW, RangedWeaponsTable::TWO_HANDED, false],

            [ArrowCode::CRIPPLING_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [ArrowCode::CRIPPLING_ARROW, RangedWeaponsTable::OFFENSIVENESS, -1],
            [ArrowCode::CRIPPLING_ARROW, RangedWeaponsTable::WOUNDS, -2],
            [ArrowCode::CRIPPLING_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::CRIPPLING_ARROW, RangedWeaponsTable::RANGE, -1],
            [ArrowCode::CRIPPLING_ARROW, RangedWeaponsTable::COVER, 0],
            [ArrowCode::CRIPPLING_ARROW, RangedWeaponsTable::WEIGHT, 0.05],
            [ArrowCode::CRIPPLING_ARROW, RangedWeaponsTable::TWO_HANDED, false],

            [ArrowCode::INCENDIARY_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [ArrowCode::INCENDIARY_ARROW, RangedWeaponsTable::OFFENSIVENESS, -3],
            [ArrowCode::INCENDIARY_ARROW, RangedWeaponsTable::WOUNDS, -3],
            [ArrowCode::INCENDIARY_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [ArrowCode::INCENDIARY_ARROW, RangedWeaponsTable::RANGE, -2],
            [ArrowCode::INCENDIARY_ARROW, RangedWeaponsTable::COVER, 0],
            [ArrowCode::INCENDIARY_ARROW, RangedWeaponsTable::WEIGHT, 0.05],
            [ArrowCode::INCENDIARY_ARROW, RangedWeaponsTable::TWO_HANDED, false],

            [ArrowCode::SILVER_ARROW, RangedWeaponsTable::REQUIRED_STRENGTH, false],
            [ArrowCode::SILVER_ARROW, RangedWeaponsTable::OFFENSIVENESS, 0],
            [ArrowCode::SILVER_ARROW, RangedWeaponsTable::WOUNDS, 0],
            [ArrowCode::SILVER_ARROW, RangedWeaponsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [ArrowCode::SILVER_ARROW, RangedWeaponsTable::RANGE, 0],
            [ArrowCode::SILVER_ARROW, RangedWeaponsTable::COVER, 0],
            [ArrowCode::SILVER_ARROW, RangedWeaponsTable::WEIGHT, 0.05],
            [ArrowCode::SILVER_ARROW, RangedWeaponsTable::TWO_HANDED, false],
        ];
    }

}