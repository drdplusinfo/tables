<?php
namespace DrdPlus\Tests\Tables\Armaments\Armors;

use DrdPlus\Tables\Armaments\Armors\ArmorSanctionsTable;
use DrdPlus\Tests\Tables\TableTestInterface;

class ArmorSanctionsTableTest extends \PHPUnit_Framework_TestCase implements TableTestInterface
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $armorSanctionsTable = new ArmorSanctionsTable();
        self::assertSame(
            [['missing_strength', 'sanction_description', 'agility_sanction', 'can_move']],
            $armorSanctionsTable->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_all_values()
    {
        self::assertSame(
            [
                0 => [
                    'missing_strength' => 0,
                    'sanction_description' => 'light',
                    'agility_sanction' => 0,
                    'can_move' => true
                ],
                3 => [
                    'missing_strength' => 3,
                    'sanction_description' => 'medium',
                    'agility_sanction' => -2,
                    'can_move' => true
                ],
                6 => [
                    'missing_strength' => 6,
                    'sanction_description' => 'heavy',
                    'agility_sanction' => -4,
                    'can_move' => true
                ],
                8 => [
                    'missing_strength' => 8,
                    'sanction_description' => 'very_heavy',
                    'agility_sanction' => -8,
                    'can_move' => true
                ],
                10 => [
                    'missing_strength' => 10,
                    'sanction_description' => 'extreme',
                    'agility_sanction' => -12,
                    'can_move' => true
                ],
                11 => [
                    'missing_strength' => 11,
                    'sanction_description' => 'unbearable',
                    'agility_sanction' => false,
                    'can_move' => false
                ],
            ],
            (new ArmorSanctionsTable())->getIndexedValues()
        );
    }

    /**
     * @test
     * @dataProvider provideMissingStrengthAndResult
     * @param bool|int missingStrength
     * @param array $expectedValues
     */
    public function I_can_get_sanction_data_for_any_strength_missing($missingStrength, array $expectedValues)
    {
        $armorSanctionsTable = new ArmorSanctionsTable();
        self::assertSame(
            $expectedValues,
            $armorSanctionsTable->getSanctionsForMissingStrength($missingStrength),
            'Expected ' . serialize($expectedValues) . " for missing strength $missingStrength"
        );
    }

    public function provideMissingStrengthAndResult()
    {
        $values = [];
        for ($missingStrength = -5; $missingStrength <= 0; $missingStrength++) {
            $values[] = [
                $missingStrength,
                [
                    ArmorSanctionsTable::MISSING_STRENGTH => 0,
                    ArmorSanctionsTable::SANCTION_DESCRIPTION => 'light',
                    ArmorSanctionsTable::AGILITY_SANCTION => 0,
                    ArmorSanctionsTable::CAN_MOVE => true,
                ]
            ];
        }
        for ($missingStrength = 1; $missingStrength <= 3; $missingStrength++) {
            $values[] = [
                $missingStrength,
                [
                    ArmorSanctionsTable::MISSING_STRENGTH => 3,
                    ArmorSanctionsTable::SANCTION_DESCRIPTION => 'medium',
                    ArmorSanctionsTable::AGILITY_SANCTION => -2,
                    ArmorSanctionsTable::CAN_MOVE => true,
                ]
            ];
        }
        for ($missingStrength = 4; $missingStrength <= 6; $missingStrength++) {
            $values[] = [
                $missingStrength,
                [
                    ArmorSanctionsTable::MISSING_STRENGTH => 6,
                    ArmorSanctionsTable::SANCTION_DESCRIPTION => 'heavy',
                    ArmorSanctionsTable::AGILITY_SANCTION => -4,
                    ArmorSanctionsTable::CAN_MOVE => true,
                ]
            ];
        }
        for ($missingStrength = 7; $missingStrength <= 8; $missingStrength++) {
            $values[] = [
                $missingStrength,
                [
                    ArmorSanctionsTable::MISSING_STRENGTH => 8,
                    ArmorSanctionsTable::SANCTION_DESCRIPTION => 'very_heavy',
                    ArmorSanctionsTable::AGILITY_SANCTION => -8,
                    ArmorSanctionsTable::CAN_MOVE => true,
                ]
            ];
        }
        for ($missingStrength = 9; $missingStrength <= 10; $missingStrength++) {
            $values[] = [
                $missingStrength,
                [
                    ArmorSanctionsTable::MISSING_STRENGTH => 10,
                    ArmorSanctionsTable::SANCTION_DESCRIPTION => 'extreme',
                    ArmorSanctionsTable::AGILITY_SANCTION => -12,
                    ArmorSanctionsTable::CAN_MOVE => true,
                ]
            ];
        }
        for ($missingStrength = 11; $missingStrength <= 20; $missingStrength++) {
            $values[] = [
                $missingStrength,
                [
                    ArmorSanctionsTable::MISSING_STRENGTH => 11,
                    ArmorSanctionsTable::SANCTION_DESCRIPTION => 'unbearable',
                    ArmorSanctionsTable::AGILITY_SANCTION => false,
                    ArmorSanctionsTable::CAN_MOVE => false,
                ]
            ];
        }

        return $values;
    }

    /**
     * @test
     */
    public function I_can_find_out_if_can_move()
    {
        $armorSanctionsTable = new ArmorSanctionsTable();
        self::assertTrue($armorSanctionsTable->canMove(-10));
        self::assertTrue($armorSanctionsTable->canMove(10));
        self::assertFalse($armorSanctionsTable->canMove(11));
        self::assertFalse($armorSanctionsTable->canMove(100));
    }

    /**
     * @test
     */
    public function I_can_get_sanction_description()
    {
        $armorSanctionsTable = new ArmorSanctionsTable();
        self::assertSame('light', $armorSanctionsTable->getSanctionDescription(-10));
        self::assertSame('extreme', $armorSanctionsTable->getSanctionDescription(10));
        self::assertSame('unbearable', $armorSanctionsTable->getSanctionDescription(999));
    }

    /**
     * @test
     */
    public function I_can_get_agility_malus()
    {
        $armorSanctionsTable = new ArmorSanctionsTable();
        self::assertSame(0, $armorSanctionsTable->getAgilityMalus(-10));
        self::assertSame(-8, $armorSanctionsTable->getAgilityMalus(7));
        self::assertSame(-8, $armorSanctionsTable->getAgilityMalus(8));
        self::assertSame(-12, $armorSanctionsTable->getAgilityMalus(9));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Armors\Exceptions\CanNotUseArmorBecauseOfMissingStrength
     */
    public function I_can_not_get_agility_malus_if_unbearable()
    {
        $armorSanctionsTable = new ArmorSanctionsTable();
        self::assertSame(0, $armorSanctionsTable->getAgilityMalus(11));
    }
}