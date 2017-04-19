<?php
namespace DrdPlus\Tests\Tables\Body\MovementTypes;

use DrdPlus\Codes\TimeCode;
use DrdPlus\Codes\Transport\MovementTypeCode;
use DrdPlus\Properties\Derived\Endurance;
use DrdPlus\Tables\Body\MovementTypes\MovementTypesTable;
use DrdPlus\Tables\Measurements\Speed\SpeedBonus;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tables\Measurements\Time\TimeBonus;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tests\Tables\TableTest;

class MovementTypesTableTest extends TableTest
{
    /**
     * @var SpeedTable
     */
    private $speedTable;
    /**
     * @var TimeTable
     */
    private $timeTable;

    protected function setUp()
    {
        $this->speedTable = new SpeedTable();
        $this->timeTable = new TimeTable();
    }

    /**
     * @test
     */
    public function I_can_get_header()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        self::assertSame(
            [
                ['movement_type', 'bonus_to_movement_speed', 'hours_per_point_of_fatigue', 'minutes_per_point_of_fatigue', 'rounds_per_point_of_fatigue']
            ],
            $movementTypesTable->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_all_values()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        self::assertSame(
            [
                MovementTypeCode::WAITING => [
                    'bonus_to_movement_speed' => 0,
                    'hours_per_point_of_fatigue' => false,
                    'minutes_per_point_of_fatigue' => false,
                    'rounds_per_point_of_fatigue' => false,
                ],
                MovementTypeCode::WALK => [
                    'bonus_to_movement_speed' => 23,
                    'hours_per_point_of_fatigue' => 1.0,
                    'minutes_per_point_of_fatigue' => false,
                    'rounds_per_point_of_fatigue' => false,
                ],
                MovementTypeCode::RUSH => [
                    'bonus_to_movement_speed' => 26,
                    'hours_per_point_of_fatigue' => 0.5,
                    'minutes_per_point_of_fatigue' => false,
                    'rounds_per_point_of_fatigue' => false,
                ],
                MovementTypeCode::RUN => [
                    'bonus_to_movement_speed' => 32,
                    'hours_per_point_of_fatigue' => false,
                    'minutes_per_point_of_fatigue' => 5.0,
                    'rounds_per_point_of_fatigue' => false,
                ],
                MovementTypeCode::SPRINT => [
                    'bonus_to_movement_speed' => 36,
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
     * @param Time|bool $expectedPeriod
     */
    public function I_can_get_bonus_and_time_per_point_of_fatigue($type, $expectedBonus, $expectedPeriod)
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        self::assertEquals($expectedBonus, $movementTypesTable->getSpeedBonus($type));
        if ($expectedPeriod instanceof Time) {
            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            self::assertEquals($expectedPeriod, $movementTypesTable->getPeriodForPointOfFatigue($type));
        } else {
            self::assertSame($expectedPeriod, $movementTypesTable->getPeriodForPointOfFatigue($type));
        }
    }

    public function provideTypeAndExpectedBonusAndPeriod(): array
    {
        $timeTable = new TimeTable();
        $speedTable = new SpeedTable();

        return [
            [MovementTypeCode::WAITING, new SpeedBonus(0, $speedTable), false],
            [MovementTypeCode::WALK, new SpeedBonus(23, $speedTable), new Time(1, TimeCode::HOUR, $timeTable)],
            [MovementTypeCode::RUSH, new SpeedBonus(26, $speedTable), new Time(0.5, TimeCode::HOUR, $timeTable)],
            [MovementTypeCode::RUN, new SpeedBonus(32, $speedTable), new Time(5, TimeCode::MINUTE, $timeTable)],
            [MovementTypeCode::SPRINT, new SpeedBonus(36, $speedTable), new Time(2, TimeCode::ROUND, $timeTable)],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_waiting_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        self::assertEquals(new SpeedBonus(0, $this->speedTable), $movementTypesTable->getSpeedBonusOnWaiting());
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_walk_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        self::assertEquals(new SpeedBonus(23, $this->speedTable), $movementTypesTable->getSpeedBonusOnWalk());
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_rush_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        self::assertEquals(new SpeedBonus(26, $this->speedTable), $movementTypesTable->getSpeedBonusOnRush());
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_run_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        self::assertEquals(new SpeedBonus(32, $this->speedTable), $movementTypesTable->getSpeedBonusOnRun());
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_sprint_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        self::assertEquals(new SpeedBonus(36, $this->speedTable), $movementTypesTable->getSpeedBonusOnSprint());
    }

    /**
     * @test
     */
    public function I_can_get_period_for_point_fatigue_on_walk_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        self::assertEquals(new Time(1, TimeCode::HOUR, $this->timeTable), $movementTypesTable->getPeriodForPointOfFatigueOnWalk());
    }

    /**
     * @test
     */
    public function I_can_get_period_for_point_fatigue_on_rush_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        self::assertEquals(new Time(0.5, TimeCode::HOUR, $this->timeTable), $movementTypesTable->getPeriodForPointOfFatigueOnRush());
    }

    /**
     * @test
     */
    public function I_can_get_period_for_point_fatigue_on_run_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        self::assertEquals(new Time(5, TimeCode::MINUTE, $this->timeTable), $movementTypesTable->getPeriodForPointOfFatigueOnRun());
    }

    /**
     * @test
     */
    public function I_can_get_period_for_point_fatigue_on_sprint_by_simple_getter()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        self::assertEquals(new Time(2, TimeCode::ROUND, $this->timeTable), $movementTypesTable->getPeriodForPointOfFatigueOnSprint());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Body\MovementTypes\Exceptions\UnknownMovementType
     * @expectedExceptionMessageRegExp ~moonwalk~
     */
    public function I_can_not_get_movement_bonus_for_unknown_type()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
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
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        $movementTypesTable->getPeriodForPointOfFatigue('sneaking');
    }

    /**
     * @test
     */
    public function I_can_get_maximum_time_of_sprint()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        $timeBonus = $movementTypesTable->getMaximumTimeBonusToSprint($this->createEndurance(123));
        self::assertInstanceOf(TimeBonus::class, $timeBonus);
        self::assertSame(123, $timeBonus->getValue());
    }

    /**
     * @test
     */
    public function I_can_get_required_time_of_walk_after_maximum_sprint()
    {
        $movementTypesTable = new MovementTypesTable($this->speedTable, $this->timeTable);
        $timeBonus = $movementTypesTable->getRequiredTimeBonusToWalkAfterFullSprint($this->createEndurance(456));
        self::assertInstanceOf(TimeBonus::class, $timeBonus);
        self::assertSame(476, $timeBonus->getValue());
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|Endurance
     */
    private function createEndurance($value)
    {
        $endurance = $this->mockery(Endurance::class);
        $endurance->shouldReceive('getValue')
            ->andReturn($value);

        return $endurance;
    }
}