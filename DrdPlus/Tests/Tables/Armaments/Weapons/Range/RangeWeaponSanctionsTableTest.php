<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range;

use DrdPlus\Tables\Armaments\Sanctions\RangeWeaponSanctionsTable;
use DrdPlus\Tests\Tables\TableTestInterface;

class RangeWeaponSanctionsTableTest extends \PHPUnit_Framework_TestCase implements TableTestInterface
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $shootingWeaponSanctionsTable = new RangeWeaponSanctionsTable();
        self::assertSame(
            [
                [
                    'missing_strength',
                    'fight_number',
                    'loading',
                    'attack_number',
                    'encounter_range',
                    'base_of_wounds',
                    'can_use_weapon'
                ]
            ],
            $shootingWeaponSanctionsTable->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_all_values()
    {
        $shootingWeaponSanctionsTable = new RangeWeaponSanctionsTable();
        self::assertSame(
            [
                0 => [
                    'missing_strength' => 0,
                    'fight_number' => 0,
                    'loading' => 0,
                    'attack_number' => 0,
                    'encounter_range' => 0,
                    'base_of_wounds' => 0,
                    'can_use_weapon' => true
                ],
                1 => [
                    'missing_strength' => 1,
                    'fight_number' => -1,
                    'loading' => 1,
                    'attack_number' => 0,
                    'encounter_range' => 0,
                    'base_of_wounds' => 0,
                    'can_use_weapon' => true
                ],
                2 => [
                    'missing_strength' => 2,
                    'fight_number' => -2,
                    'loading' => 1,
                    'attack_number' => -1,
                    'encounter_range' => 0,
                    'base_of_wounds' => 0,
                    'can_use_weapon' => true
                ],
                3 => [
                    'missing_strength' => 3,
                    'fight_number' => -3,
                    'loading' => 1,
                    'attack_number' => -1,
                    'encounter_range' => -1,
                    'base_of_wounds' => 0,
                    'can_use_weapon' => true
                ],
                4 => [
                    'missing_strength' => 4,
                    'fight_number' => -4,
                    'loading' => 1,
                    'attack_number' => -2,
                    'encounter_range' => -1,
                    'base_of_wounds' => -1,
                    'can_use_weapon' => true
                ],
                5 => [
                    'missing_strength' => 5,
                    'fight_number' => -5,
                    'loading' => 1,
                    'attack_number' => -2,
                    'encounter_range' => -2,
                    'base_of_wounds' => -1,
                    'can_use_weapon' => true
                ],
                6 => [
                    'missing_strength' => 6,
                    'fight_number' => -6,
                    'loading' => 1,
                    'attack_number' => -3,
                    'encounter_range' => -2,
                    'base_of_wounds' => -2,
                    'can_use_weapon' => true
                ],
                7 => [
                    'missing_strength' => 7,
                    'fight_number' => -1,
                    'loading' => 2,
                    'attack_number' => -3,
                    'encounter_range' => -3,
                    'base_of_wounds' => -2,
                    'can_use_weapon' => true
                ],
                8 => [
                    'missing_strength' => 8,
                    'fight_number' => -2,
                    'loading' => 2,
                    'attack_number' => -4,
                    'encounter_range' => -3,
                    'base_of_wounds' => -3,
                    'can_use_weapon' => true
                ],
                9 => [
                    'missing_strength' => 9,
                    'fight_number' => -3,
                    'loading' => 2,
                    'attack_number' => -4,
                    'encounter_range' => -4,
                    'base_of_wounds' => -3,
                    'can_use_weapon' => true
                ],
                10 => [
                    'missing_strength' => 10,
                    'fight_number' => -4,
                    'loading' => 2,
                    'attack_number' => -5,
                    'encounter_range' => -4,
                    'base_of_wounds' => -4,
                    'can_use_weapon' => true
                ],
                11 => [
                    'missing_strength' => 11,
                    'fight_number' => false,
                    'loading' => false,
                    'attack_number' => false,
                    'encounter_range' => false,
                    'base_of_wounds' => false,
                    'can_use_weapon' => false
                ],
            ],
            $shootingWeaponSanctionsTable->getIndexedValues()
        );
    }

    /**
     * @test
     * @dataProvider provideMissingStrengthAndUsableResult
     * @param int $missingStrength
     * @param bool $canUse
     */
    public function I_can_properly_detect_if_can_use_a_shooting_weapon($missingStrength, $canUse)
    {
        $shootingWeaponSanctionsTable = new RangeWeaponSanctionsTable();
        self::assertSame($canUse, $shootingWeaponSanctionsTable->canUseWeapon($missingStrength));
    }

    public function provideMissingStrengthAndUsableResult()
    {
        return [
            [99, false],
            [12, false],
            [11, false],
            [10, true],
            [1, true],
            [0, true],
            [-1, true],
            [-10, true],
        ];
    }

    /**
     * @test
     * @dataProvider provideMissingStrengthAndFightSanction
     * @param int $missingStrength
     * @param int $expectedSanction
     */
    public function I_can_get_fight_number_sanction($missingStrength, $expectedSanction)
    {
        $shootingWeaponSanctionsTable = new RangeWeaponSanctionsTable();
        self::assertSame($expectedSanction, $shootingWeaponSanctionsTable->getFightNumberSanction($missingStrength));
    }

    public function provideMissingStrengthAndFightSanction()
    {
        return [
            [10, -4],
            [9, -3],
            [8, -2],
            [7, -1],
            [6, -6],
            [5, -5],
            [4, -4],
            [3, -3],
            [2, -2],
            [1, -1],
        ];
    }

    /**
     * @test
     * @dataProvider provideMissingStrengthAndLoadingSanction
     * @param int $missingStrength
     * @param int $expectedSanction
     */
    public function I_can_get_loading_sanction($missingStrength, $expectedSanction)
    {
        $shootingWeaponSanctionsTable = new RangeWeaponSanctionsTable();
        self::assertSame($expectedSanction, $shootingWeaponSanctionsTable->getLoadingSanction($missingStrength));
    }

    public function provideMissingStrengthAndLoadingSanction()
    {
        return [
            [10, 2],
            [9, 2],
            [8, 2],
            [7, 2],
            [6, 1],
            [5, 1],
            [4, 1],
            [3, 1],
            [2, 1],
            [1, 1],
        ];
    }

    /**
     * @test
     * @dataProvider provideMissingStrengthAndAttackNumberSanction
     * @param int $missingStrength
     * @param int $expectedSanction
     */
    public function I_can_get_attack_number_sanction($missingStrength, $expectedSanction)
    {
        $shootingWeaponSanctionsTable = new RangeWeaponSanctionsTable();
        self::assertSame($expectedSanction, $shootingWeaponSanctionsTable->getAttackNumberSanction($missingStrength));
    }

    public function provideMissingStrengthAndAttackNumberSanction()
    {
        return [
            [10, -5],
            [9, -4],
            [8, -4],
            [7, -3],
            [6, -3],
            [5, -2],
            [4, -2],
            [3, -1],
            [2, -1],
            [1, 0],
        ];
    }

    /**
     * @test
     * @dataProvider provideMissingStrengthAndEncounterRangeSanction
     * @param int $missingStrength
     * @param int $expectedSanction
     */
    public function I_can_get_encounter_range_sanction($missingStrength, $expectedSanction)
    {
        $shootingWeaponSanctionsTable = new RangeWeaponSanctionsTable();
        self::assertSame($expectedSanction, $shootingWeaponSanctionsTable->getEncounterRangeSanction($missingStrength));
    }

    public function provideMissingStrengthAndEncounterRangeSanction()
    {
        return [
            [10, -4],
            [9, -4],
            [8, -3],
            [7, -3],
            [6, -2],
            [5, -2],
            [4, -1],
            [3, -1],
            [2, 0],
            [1, 0],
        ];
    }

    /**
     * @test
     * @dataProvider provideMissingStrengthAndBaseOfWoundsSanction
     * @param int $missingStrength
     * @param int $expectedSanction
     */
    public function I_can_get_base_of_wounds_sanction($missingStrength, $expectedSanction)
    {
        $shootingWeaponSanctionsTable = new RangeWeaponSanctionsTable();
        self::assertSame($expectedSanction, $shootingWeaponSanctionsTable->getBaseOfWoundsSanction($missingStrength));
    }

    public function provideMissingStrengthAndBaseOfWoundsSanction()
    {
        return [
            [10, -4],
            [9, -3],
            [8, -3],
            [7, -2],
            [6, -2],
            [5, -1],
            [4, -1],
            [3, 0],
            [2, 0],
            [1, 0],
        ];
    }

    /**
     * @test
     * @dataProvider provideSanctionName
     * @param string $sanctionName
     */
    public function I_get_always_zero_for_every_sanction_if_no_missing_strength($sanctionName)
    {
        $sanctionGetter = 'get' . ucfirst($sanctionName) . 'Sanction';
        $shootingWeaponSanctionsTable = new RangeWeaponSanctionsTable();
        self::assertSame(0, $shootingWeaponSanctionsTable->$sanctionGetter(0));
        self::assertSame(0, $shootingWeaponSanctionsTable->$sanctionGetter(-1));
        self::assertSame(0, $shootingWeaponSanctionsTable->$sanctionGetter(-10));
    }

    public function provideSanctionName()
    {
        return [
            ['fightNumber'],
            ['loading'],
            ['attackNumber'],
            ['encounterRange'],
            ['baseOfWounds'],
        ];
    }

    /**
     * @test
     * @dataProvider provideSanctionName
     * @param string $sanctionName
     * @expectedException \DrdPlus\Tables\Armaments\Sanctions\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     */
    public function I_can_not_get_any_sanction_for_too_much_missing_strength($sanctionName)
    {
        $sanctionGetter = 'get' . ucfirst($sanctionName) . 'Sanction';
        $shootingWeaponSanctionsTable = new RangeWeaponSanctionsTable();
        $shootingWeaponSanctionsTable->$sanctionGetter(11);
    }

}
