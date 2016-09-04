<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Ranged;

use DrdPlus\Codes\Armaments\RangedWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Ranged\BowsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTableTest;

class BowsTableTest extends RangedWeaponsTableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $bowsTable = new BowsTable();
        self::assertSame(
            [['weapon', 'required_strength', 'maximal_applicable_strength', 'offensiveness', 'wounds', 'wounds_type', 'range', 'cover', 'weight', 'two_handed']],
            $bowsTable->getHeader()
        );
    }

    protected function getRowHeaderName()
    {
        return 'weapon';
    }

    public function provideArmamentAndNameWithValue()
    {
        return [
            [RangedWeaponCode::SHORT_BOW, BowsTable::REQUIRED_STRENGTH, -1],
            [RangedWeaponCode::SHORT_BOW, BowsTable::MAXIMAL_APPLICABLE_STRENGTH, 3],
            [RangedWeaponCode::SHORT_BOW, BowsTable::OFFENSIVENESS, 2],
            [RangedWeaponCode::SHORT_BOW, BowsTable::WOUNDS, 1],
            [RangedWeaponCode::SHORT_BOW, BowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::SHORT_BOW, BowsTable::RANGE, 24],
            [RangedWeaponCode::SHORT_BOW, BowsTable::COVER, 2],
            [RangedWeaponCode::SHORT_BOW, BowsTable::WEIGHT, 1.0],
            [RangedWeaponCode::SHORT_BOW, BowsTable::TWO_HANDED, true],

            [RangedWeaponCode::LONG_BOW, BowsTable::REQUIRED_STRENGTH, 5],
            [RangedWeaponCode::LONG_BOW, BowsTable::MAXIMAL_APPLICABLE_STRENGTH, 7],
            [RangedWeaponCode::LONG_BOW, BowsTable::OFFENSIVENESS, 3],
            [RangedWeaponCode::LONG_BOW, BowsTable::WOUNDS, 4],
            [RangedWeaponCode::LONG_BOW, BowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::LONG_BOW, BowsTable::RANGE, 27],
            [RangedWeaponCode::LONG_BOW, BowsTable::COVER, 2],
            [RangedWeaponCode::LONG_BOW, BowsTable::WEIGHT, 1.2],
            [RangedWeaponCode::LONG_BOW, BowsTable::TWO_HANDED, true],

            [RangedWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::REQUIRED_STRENGTH, 1],
            [RangedWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::MAXIMAL_APPLICABLE_STRENGTH, 6],
            [RangedWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::OFFENSIVENESS, 3],
            [RangedWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::WOUNDS, 2],
            [RangedWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::RANGE, 26],
            [RangedWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::COVER, 2],
            [RangedWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::WEIGHT, 1.0],
            [RangedWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::TWO_HANDED, true],

            [RangedWeaponCode::LONG_COMPOSITE_BOW, BowsTable::REQUIRED_STRENGTH, 5],
            [RangedWeaponCode::LONG_COMPOSITE_BOW, BowsTable::MAXIMAL_APPLICABLE_STRENGTH, 9],
            [RangedWeaponCode::LONG_COMPOSITE_BOW, BowsTable::OFFENSIVENESS, 4],
            [RangedWeaponCode::LONG_COMPOSITE_BOW, BowsTable::WOUNDS, 5],
            [RangedWeaponCode::LONG_COMPOSITE_BOW, BowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::LONG_COMPOSITE_BOW, BowsTable::RANGE, 29],
            [RangedWeaponCode::LONG_COMPOSITE_BOW, BowsTable::COVER, 2],
            [RangedWeaponCode::LONG_COMPOSITE_BOW, BowsTable::WEIGHT, 1.5],
            [RangedWeaponCode::LONG_COMPOSITE_BOW, BowsTable::TWO_HANDED, true],

            [RangedWeaponCode::POWER_BOW, BowsTable::REQUIRED_STRENGTH, 7],
            [RangedWeaponCode::POWER_BOW, BowsTable::MAXIMAL_APPLICABLE_STRENGTH, 12],
            [RangedWeaponCode::POWER_BOW, BowsTable::OFFENSIVENESS, 5],
            [RangedWeaponCode::POWER_BOW, BowsTable::WOUNDS, 6],
            [RangedWeaponCode::POWER_BOW, BowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangedWeaponCode::POWER_BOW, BowsTable::RANGE, 31],
            [RangedWeaponCode::POWER_BOW, BowsTable::COVER, 2],
            [RangedWeaponCode::POWER_BOW, BowsTable::WEIGHT, 2.0],
            [RangedWeaponCode::POWER_BOW, BowsTable::TWO_HANDED, true],
        ];
    }

}