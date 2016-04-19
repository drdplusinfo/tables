<?php
namespace DrdPlus\Tests\Tables\Armaments\Sanctions;

use DrdPlus\Tables\Armaments\Sanctions\ArmorSanctionsTable;
use DrdPlus\Tests\Tables\TableTest;

class SanctionsForArmorTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $sanctionsForArmorTable = new ArmorSanctionsTable();
        self::assertSame(
            [['minimal_missing_strength', 'maximal_missing_strength', 'description', 'agility_sanction', 'can_move']],
            $sanctionsForArmorTable->getHeader()
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
        $sanctionsForArmorTable = new ArmorSanctionsTable();
        self::assertSame(
            $expectedValues,
            $sanctionsForArmorTable->getSanctionValuesForMissingStrength($missingStrength)
        );
    }

    public function provideMissingStrengthAndResult()
    {
        $lightLoad = [
            ArmorSanctionsTable::MINIMAL_MISSING_STRENGTH_HEADER => false,
            ArmorSanctionsTable::MAXIMAL_MISSING_STRENGTH_HEADER => 0,
            ArmorSanctionsTable::DESCRIPTION_HEADER => 'light',
            ArmorSanctionsTable::AGILITY_SANCTION_HEADER => 0,
            ArmorSanctionsTable::CAN_MOVE_HEADER => true,
        ];
        $mediumLoad = [
            ArmorSanctionsTable::MINIMAL_MISSING_STRENGTH_HEADER => 1,
            ArmorSanctionsTable::MAXIMAL_MISSING_STRENGTH_HEADER => 3,
            ArmorSanctionsTable::DESCRIPTION_HEADER => 'medium',
            ArmorSanctionsTable::AGILITY_SANCTION_HEADER => -2,
            ArmorSanctionsTable::CAN_MOVE_HEADER => true,
        ];
        $heavyLoad = [
            ArmorSanctionsTable::MINIMAL_MISSING_STRENGTH_HEADER => 4,
            ArmorSanctionsTable::MAXIMAL_MISSING_STRENGTH_HEADER => 6,
            ArmorSanctionsTable::DESCRIPTION_HEADER => 'heavy',
            ArmorSanctionsTable::AGILITY_SANCTION_HEADER => -4,
            ArmorSanctionsTable::CAN_MOVE_HEADER => true,
        ];
        $veryHeavyLoad = [
            ArmorSanctionsTable::MINIMAL_MISSING_STRENGTH_HEADER => 7,
            ArmorSanctionsTable::MAXIMAL_MISSING_STRENGTH_HEADER => 8,
            ArmorSanctionsTable::DESCRIPTION_HEADER => 'very heavy',
            ArmorSanctionsTable::AGILITY_SANCTION_HEADER => -8,
            ArmorSanctionsTable::CAN_MOVE_HEADER => true,
        ];
        $extremeLoad = [
            ArmorSanctionsTable::MINIMAL_MISSING_STRENGTH_HEADER => 9,
            ArmorSanctionsTable::MAXIMAL_MISSING_STRENGTH_HEADER => 10,
            ArmorSanctionsTable::DESCRIPTION_HEADER => 'extreme',
            ArmorSanctionsTable::AGILITY_SANCTION_HEADER => -12,
            ArmorSanctionsTable::CAN_MOVE_HEADER => true,
        ];
        $unbearableLoad = [
            ArmorSanctionsTable::MINIMAL_MISSING_STRENGTH_HEADER => 11,
            ArmorSanctionsTable::MAXIMAL_MISSING_STRENGTH_HEADER => false,
            ArmorSanctionsTable::DESCRIPTION_HEADER => 'unbearable',
            ArmorSanctionsTable::AGILITY_SANCTION_HEADER => false,
            ArmorSanctionsTable::CAN_MOVE_HEADER => false,
        ];

        $values = [
            [false, $lightLoad],
        ];

        for ($missingStrength = -5; $missingStrength < 20; $missingStrength++) {
            if ($missingStrength <= 0) {
                $values[] = [$missingStrength, $lightLoad];
            } else if ($missingStrength <= 3) {
                $values[] = [$missingStrength, $mediumLoad];
            } else if ($missingStrength <= 6) {
                $values[] = [$missingStrength, $heavyLoad];
            } else if ($missingStrength <= 8) {
                $values[] = [$missingStrength, $veryHeavyLoad];
            } else if ($missingStrength <= 10) {
                $values[] = [$missingStrength, $extremeLoad];
            } else {
                $values[] = [$missingStrength, $unbearableLoad];
            }
        }

        return $values;
    }
}