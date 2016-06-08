<?php
namespace DrdPlus\Tests\Tables\Body\MovementTypes;

use DrdPlus\Tables\Body\MovementTypes\MovementTypesTable;
use DrdPlus\Tables\Measurements\Speed\SpeedBonus;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tests\Tables\TableTest;

class MovementTypesTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @var SpeedTable
     */
    private $speedTable;

    protected function setUp()
    {
        $this->speedTable = new SpeedTable();
    }

    /**
     * @test
     */
    public function I_can_get_header()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable);
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
        $movementTypesTable = new MovementTypesTable($this->speedTable);
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
        $movementTypesTable = new MovementTypesTable($this->speedTable);
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        self::assertEquals($expectedBonus, $movementTypesTable->getSpeedBonus($type));
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        self::assertEquals($expectedPeriod, $movementTypesTable->getPeriodOfPointOfFatigue($type));
    }

    public function provideTypeAndExpectedBonusAndPeriod()
    {
        $timeTable = new TimeTable();
        $speedTable = new SpeedTable();

        return [
            ['walk', new SpeedBonus(23, $speedTable), new Time(1, Time::HOUR, $timeTable)],
            ['rush', new SpeedBonus(26, $speedTable), new Time(0.5, Time::HOUR, $timeTable)],
            ['run', new SpeedBonus(32, $speedTable), new Time(5, Time::MINUTE, $timeTable)],
            ['sprint', new SpeedBonus(36, $speedTable), new Time(2, Time::ROUND, $timeTable)],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_walk_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable);

        self::assertEquals(new SpeedBonus(23, $this->speedTable), $movementTypesTable->getSpeedBonusOnWalk());
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_rush_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable);

        self::assertEquals(new SpeedBonus(26, $this->speedTable), $movementTypesTable->getSpeedBonusOnRush());
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_run_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable);

        self::assertEquals(new SpeedBonus(32, $this->speedTable), $movementTypesTable->getSpeedBonusOnRun());
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_sprint_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable);

        self::assertEquals(new SpeedBonus(36, $this->speedTable), $movementTypesTable->getSpeedBonusOnSprint());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Body\MovementTypes\Exceptions\UnknownMovementType
     * @expectedExceptionMessageRegExp ~moonwalk~
     */
    public function I_can_not_get_movement_bonus_for_unknown_type()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable);
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $movementTypesTable->getSpeedBonus('moonwalk');
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Body\MovementTypes\Exceptions\UnknownMovementType
     * @expectedExceptionMessageRegExp ~sneaking~
     */
    public function I_can_not_get_period_of_fatigue_for_unknown_type()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable);
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $movementTypesTable->getPeriodOfPointOfFatigue('sneaking');
    }
}