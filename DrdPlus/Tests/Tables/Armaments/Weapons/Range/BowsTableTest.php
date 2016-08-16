<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Codes\RangeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Range\BowsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTableTest;

class BowsTableTest extends RangeWeaponsTableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $bowsTable = new BowsTable();
        self::assertSame(
            [['weapon', 'required_strength', 'maximal_applicable_strength', 'offensiveness', 'wounds', 'wounds_type', 'range', 'weight']],
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
            [RangeWeaponCode::SHORT_BOW, BowsTable::REQUIRED_STRENGTH, -1],
            [RangeWeaponCode::SHORT_BOW, BowsTable::MAXIMAL_APPLICABLE_STRENGTH, 3],
            [RangeWeaponCode::SHORT_BOW, BowsTable::OFFENSIVENESS, 2],
            [RangeWeaponCode::SHORT_BOW, BowsTable::WOUNDS, 1],
            [RangeWeaponCode::SHORT_BOW, BowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::SHORT_BOW, BowsTable::RANGE, 24],
            [RangeWeaponCode::SHORT_BOW, BowsTable::WEIGHT, 1.0],

            [RangeWeaponCode::LONG_BOW, BowsTable::REQUIRED_STRENGTH, 5],
            [RangeWeaponCode::LONG_BOW, BowsTable::MAXIMAL_APPLICABLE_STRENGTH, 7],
            [RangeWeaponCode::LONG_BOW, BowsTable::OFFENSIVENESS, 3],
            [RangeWeaponCode::LONG_BOW, BowsTable::WOUNDS, 4],
            [RangeWeaponCode::LONG_BOW, BowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::LONG_BOW, BowsTable::RANGE, 27],
            [RangeWeaponCode::LONG_BOW, BowsTable::WEIGHT, 1.2],

            [RangeWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::REQUIRED_STRENGTH, 1],
            [RangeWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::MAXIMAL_APPLICABLE_STRENGTH, 6],
            [RangeWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::OFFENSIVENESS, 3],
            [RangeWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::WOUNDS, 2],
            [RangeWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::RANGE, 26],
            [RangeWeaponCode::SHORT_COMPOSITE_BOW, BowsTable::WEIGHT, 1.0],

            [RangeWeaponCode::LONG_COMPOSITE_BOW, BowsTable::REQUIRED_STRENGTH, 5],
            [RangeWeaponCode::LONG_COMPOSITE_BOW, BowsTable::MAXIMAL_APPLICABLE_STRENGTH, 9],
            [RangeWeaponCode::LONG_COMPOSITE_BOW, BowsTable::OFFENSIVENESS, 4],
            [RangeWeaponCode::LONG_COMPOSITE_BOW, BowsTable::WOUNDS, 5],
            [RangeWeaponCode::LONG_COMPOSITE_BOW, BowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::LONG_COMPOSITE_BOW, BowsTable::RANGE, 29],
            [RangeWeaponCode::LONG_COMPOSITE_BOW, BowsTable::WEIGHT, 1.5],

            [RangeWeaponCode::POWER_BOW, BowsTable::REQUIRED_STRENGTH, 7],
            [RangeWeaponCode::POWER_BOW, BowsTable::MAXIMAL_APPLICABLE_STRENGTH, 12],
            [RangeWeaponCode::POWER_BOW, BowsTable::OFFENSIVENESS, 5],
            [RangeWeaponCode::POWER_BOW, BowsTable::WOUNDS, 6],
            [RangeWeaponCode::POWER_BOW, BowsTable::WOUNDS_TYPE, WoundTypeCode::STAB],
            [RangeWeaponCode::POWER_BOW, BowsTable::RANGE, 31],
            [RangeWeaponCode::POWER_BOW, BowsTable::WEIGHT, 2.0],
        ];
    }

}