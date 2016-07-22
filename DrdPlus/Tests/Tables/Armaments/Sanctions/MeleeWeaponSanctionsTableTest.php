<?php
namespace DrdPlus\Tests\Tables\Armaments\Sanctions;

use DrdPlus\Tables\Armaments\Sanctions\MeleeWeaponSanctionsTable;
use DrdPlus\Tests\Tables\TableTest;

class MeleeWeaponSanctionsTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $sanctionsForWeaponTable = new MeleeWeaponSanctionsTable();
        self::assertSame(
            [['missing_strength', 'fight_number', 'attack_number', 'defense_number', 'base_of_wounds', 'can_use_weapon']],
            $sanctionsForWeaponTable->getHeader()
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
        $sanctionsForWeaponTable = new MeleeWeaponSanctionsTable();
        self::assertSame(
            $expectedValues,
            $sanctionsForWeaponTable->getSanctionsForMissingStrength($missingStrength),
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
                    MeleeWeaponSanctionsTable::MISSING_STRENGTH => 0,
                    MeleeWeaponSanctionsTable::FIGHT_NUMBER => 0,
                    MeleeWeaponSanctionsTable::ATTACK_NUMBER => 0,
                    MeleeWeaponSanctionsTable::DEFENSE_NUMBER => 0,
                    MeleeWeaponSanctionsTable::BASE_OF_WOUNDS => 0,
                    MeleeWeaponSanctionsTable::CAN_USE_WEAPON => true,
                ]
            ];
        }
        for ($missingStrength = 1; $missingStrength <= 10; $missingStrength++) {
            $values[] = [
                $missingStrength,
                [
                    MeleeWeaponSanctionsTable::MISSING_STRENGTH => $missingStrength,
                    MeleeWeaponSanctionsTable::FIGHT_NUMBER => (int)floor(-$missingStrength / 2),
                    MeleeWeaponSanctionsTable::ATTACK_NUMBER => min(0, (int)floor((-$missingStrength + 1) / 2)),
                    MeleeWeaponSanctionsTable::DEFENSE_NUMBER => min(0, (int)floor((-$missingStrength + 2) / 2)),
                    MeleeWeaponSanctionsTable::BASE_OF_WOUNDS => min(0, (int)floor((-$missingStrength + 3) / 2)),
                    MeleeWeaponSanctionsTable::CAN_USE_WEAPON => true,
                ]
            ];
        }
        for ($missingStrength = 11; $missingStrength <= 20; $missingStrength++) {
            $values[] = [
                $missingStrength,
                [
                    MeleeWeaponSanctionsTable::MISSING_STRENGTH => 11,
                    MeleeWeaponSanctionsTable::FIGHT_NUMBER => false,
                    MeleeWeaponSanctionsTable::ATTACK_NUMBER => false,
                    MeleeWeaponSanctionsTable::DEFENSE_NUMBER => false,
                    MeleeWeaponSanctionsTable::BASE_OF_WOUNDS => false,
                    MeleeWeaponSanctionsTable::CAN_USE_WEAPON => false,
                ]
            ];
        }

        return $values;
    }
}