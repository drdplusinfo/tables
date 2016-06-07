<?php
namespace DrdPlus\Tests\Tables\Body\MovementTypes;

use DrdPlus\Tables\Body\MovementTypes\MovementTypesTable;
use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tests\Tables\TableTest;

class MovementTypesTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $movementTypesTable = new MovementTypesTable();
        self::assertSame(
            [
                ['movement_type', 'bonus_to_half_of_speed', 'hours_per_point_of_fatigue', 'minutes_per_point_of_fatigue', 'rounds_per_point_of_fatigue']
            ],
            $movementTypesTable->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_values()
    {
        $movementTypesTable = new MovementTypesTable();
        self::assertSame(
            [
                'walk' => [
                    'bonus_to_half_of_speed' => 23,
                    'hours_per_point_of_fatigue' => 1.0,
                    'minutes_per_point_of_fatigue' => false,
                    'rounds_per_point_of_fatigue' => false,
                ],
                'rush' => [
                    'bonus_to_half_of_speed' => 26,
                    'hours_per_point_of_fatigue' => 0.5,
                    'minutes_per_point_of_fatigue' => false,
                    'rounds_per_point_of_fatigue' => false,
                ],
                'run' => [
                    'bonus_to_half_of_speed' => 32,
                    'hours_per_point_of_fatigue' => false,
                    'minutes_per_point_of_fatigue' => 5.0,
                    'rounds_per_point_of_fatigue' => false,
                ],
                'sprint' => [
                    'bonus_to_half_of_speed' => 36,
                    'hours_per_point_of_fatigue' => false,
                    'minutes_per_point_of_fatigue' => false,
                    'rounds_per_point_of_fatigue' => 2.0,
                ]
            ],
            $movementTypesTable->getIndexedValues()
        );
    }

    /**
     * @test
     * @dataProvider provideTypeAndExpectedBonusAndPeriod
     * @param string $type
     * @param int $expectedBonus
     * @param Time $expectedPeriod
     */
    public function I_can_get_bonus_and_time_per_point_of_fatigue($type, $expectedBonus, Time $expectedPeriod)
    {
        $movementTypesTable = new MovementTypesTable();
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        self::assertSame($expectedBonus, $movementTypesTable->getMovementBonus($type));
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        self::assertEquals($expectedPeriod, $movementTypesTable->getPeriodOfPointOfFatigue($type));
    }

    public function provideTypeAndExpectedBonusAndPeriod()
    {
        $timeTable = new TimeTable();

        return [
            ['walk', 23, new Time(1, Time::HOUR, $timeTable)],
            ['rush', 26, new Time(0.5, Time::HOUR, $timeTable)],
            ['run', 32, new Time(5, Time::MINUTE, $timeTable)],
            ['sprint', 36, new Time(2, Time::ROUND, $timeTable)],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Body\MovementTypes\Exceptions\UnknownMovementType
     * @expectedExceptionMessageRegExp ~moonwalk~
     */
    public function I_can_not_get_movement_bonus_for_unknown_type()
    {
        $movementTypesTable = new MovementTypesTable();
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $movementTypesTable->getMovementBonus('moonwalk');
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Body\MovementTypes\Exceptions\UnknownMovementType
     * @expectedExceptionMessageRegExp ~sneaking~
     */
    public function I_can_not_get_period_of_fatigue_for_unknown_type()
    {
        $movementTypesTable = new MovementTypesTable();
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $movementTypesTable->getMovementBonus('sneaking');
    }
}