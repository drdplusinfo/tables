<?php
namespace DrdPlus\Tests\Tables\Armaments\Sanctions;

use DrdPlus\Tables\Armaments\Sanctions\ArmorSanctionsTable;
use DrdPlus\Tests\Tables\TableTest;

class ArmorSanctionsTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $armorSanctionsTable = new ArmorSanctionsTable();
        self::assertSame(
            [['missing_strength', 'description', 'agility_sanction', 'can_move']],
            $armorSanctionsTable->getHeader()
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
                    ArmorSanctionsTable::DESCRIPTION => 'light',
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
                    ArmorSanctionsTable::DESCRIPTION => 'medium',
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
                    ArmorSanctionsTable::DESCRIPTION => 'heavy',
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
                    ArmorSanctionsTable::DESCRIPTION => 'very heavy',
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
                    ArmorSanctionsTable::DESCRIPTION => 'extreme',
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
                    ArmorSanctionsTable::DESCRIPTION => 'unbearable',
                    ArmorSanctionsTable::AGILITY_SANCTION => false,
                    ArmorSanctionsTable::CAN_MOVE => false,
                ]
            ];
        }

        return $values;
    }
}