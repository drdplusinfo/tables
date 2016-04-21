<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting;

use DrdPlus\Tables\Armaments\Weapons\Shooting\ShootingWeaponAfflictionsTable;
use DrdPlus\Tests\Tables\TableTest;

class ShootingWeaponAfflictionsTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $shootingWeaponAfflictionsTable = new ShootingWeaponAfflictionsTable();
        self::assertSame(
            [
                [
                    'missing_strength',
                    'fight_number/loading',
                    'attack_number',
                    'encounter_range',
                    'base_of_wounds',
                ]
            ],
            $shootingWeaponAfflictionsTable->getHeader()
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
        $shootingWeaponAfflictionsTable = new ShootingWeaponAfflictionsTable();
        self::assertSame($canUse, $shootingWeaponAfflictionsTable->canUseWeapon($missingStrength));
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
     * @dataProvider provideMissingStrengthAndFightAffliction
     * @param int $missingStrength
     * @param int $expectedAffliction
     */
    public function I_can_get_fight_number_affliction($missingStrength, $expectedAffliction)
    {
        $shootingWeaponAfflictionsTable = new ShootingWeaponAfflictionsTable();
        self::assertSame($expectedAffliction, $shootingWeaponAfflictionsTable->getFightNumberAffliction($missingStrength));
    }

    public function provideMissingStrengthAndFightAffliction()
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
     * @dataProvider provideMissingStrengthAndLoadingAffliction
     * @param int $missingStrength
     * @param int $expectedAffliction
     */
    public function I_can_get_loading_affliction($missingStrength, $expectedAffliction)
    {
        $shootingWeaponAfflictionsTable = new ShootingWeaponAfflictionsTable();
        self::assertSame($expectedAffliction, $shootingWeaponAfflictionsTable->getLoadingAffliction($missingStrength));
    }

    public function provideMissingStrengthAndLoadingAffliction()
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
     * @dataProvider provideMissingStrengthAndAttackNumberAffliction
     * @param int $missingStrength
     * @param int $expectedAffliction
     */
    public function I_can_get_attack_number_affliction($missingStrength, $expectedAffliction)
    {
        $shootingWeaponAfflictionsTable = new ShootingWeaponAfflictionsTable();
        self::assertSame($expectedAffliction, $shootingWeaponAfflictionsTable->getAttackNumberAffliction($missingStrength));
    }

    public function provideMissingStrengthAndAttackNumberAffliction()
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
     * @dataProvider provideMissingStrengthAndEncounterRangeAffliction
     * @param int $missingStrength
     * @param int $expectedAffliction
     */
    public function I_can_get_encounter_range_affliction($missingStrength, $expectedAffliction)
    {
        $shootingWeaponAfflictionsTable = new ShootingWeaponAfflictionsTable();
        self::assertSame($expectedAffliction, $shootingWeaponAfflictionsTable->getEncounterRangeAffliction($missingStrength));
    }

    public function provideMissingStrengthAndEncounterRangeAffliction()
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
     * @dataProvider provideMissingStrengthAndBaseOfWoundsAffliction
     * @param int $missingStrength
     * @param int $expectedAffliction
     */
    public function I_can_get_base_of_wounds_affliction($missingStrength, $expectedAffliction)
    {
        $shootingWeaponAfflictionsTable = new ShootingWeaponAfflictionsTable();
        self::assertSame($expectedAffliction, $shootingWeaponAfflictionsTable->getBaseOfWoundsAffliction($missingStrength));
    }

    public function provideMissingStrengthAndBaseOfWoundsAffliction()
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
     * @dataProvider provideAfflictionName
     * @param string $afflictionName
     */
    public function I_get_always_zero_for_every_affliction_if_no_missing_strength($afflictionName)
    {
        $afflictionGetter = 'get' . ucfirst($afflictionName) . 'Affliction';
        $shootingWeaponAfflictionsTable = new ShootingWeaponAfflictionsTable();
        self::assertSame(0, $shootingWeaponAfflictionsTable->$afflictionGetter(0));
        self::assertSame(0, $shootingWeaponAfflictionsTable->$afflictionGetter(-1));
        self::assertSame(0, $shootingWeaponAfflictionsTable->$afflictionGetter(-10));
    }

    public function provideAfflictionName()
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
     * @dataProvider provideAfflictionName
     * @param string $afflictionName
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Shooting\Exceptions\CanNotUseWeaponBecauseOfMissingStrength
     */
    public function I_can_not_get_any_affliction_for_too_much_missing_strength($afflictionName)
    {
        $afflictionGetter = 'get' . ucfirst($afflictionName) . 'Affliction';
        $shootingWeaponAfflictionsTable = new ShootingWeaponAfflictionsTable();
        $shootingWeaponAfflictionsTable->$afflictionGetter(11);
    }

}
