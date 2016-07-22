<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Tables\Armaments\Sanctions\ShootingWeaponSanctionsTable;
use DrdPlus\Tests\Tables\TableTest;

class ShootingWeaponSanctionsTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $shootingWeaponSanctionsTable = new ShootingWeaponSanctionsTable();
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
     * @dataProvider provideMissingStrengthAndUsableResult
     * @param int $missingStrength
     * @param bool $canUse
     */
    public function I_can_properly_detect_if_can_use_a_shooting_weapon($missingStrength, $canUse)
    {
        $shootingWeaponSanctionsTable = new ShootingWeaponSanctionsTable();
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
        $shootingWeaponSanctionsTable = new ShootingWeaponSanctionsTable();
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
        $shootingWeaponSanctionsTable = new ShootingWeaponSanctionsTable();
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
        $shootingWeaponSanctionsTable = new ShootingWeaponSanctionsTable();
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
        $shootingWeaponSanctionsTable = new ShootingWeaponSanctionsTable();
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
        $shootingWeaponSanctionsTable = new ShootingWeaponSanctionsTable();
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
        $shootingWeaponSanctionsTable = new ShootingWeaponSanctionsTable();
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
        $shootingWeaponSanctionsTable = new ShootingWeaponSanctionsTable();
        $shootingWeaponSanctionsTable->$sanctionGetter(11);
    }

}
