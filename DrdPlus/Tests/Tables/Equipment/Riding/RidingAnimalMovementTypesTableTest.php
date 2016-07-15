<?php
namespace DrdPlus\Tests\Tables\Equipment\Riding;

use DrdPlus\Codes\RidingAnimalMovementCode;
use DrdPlus\Properties\Derived\Endurance;
use DrdPlus\Tables\Body\MovementTypes\MovementTypesTable;
use DrdPlus\Tables\Equipment\Riding\RidingAnimalMovementTypesTable;
use DrdPlus\Tables\Measurements\Speed\SpeedBonus;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
use DrdPlus\Tables\Measurements\Time\Time;
use DrdPlus\Tables\Measurements\Time\TimeTable;
use DrdPlus\Tests\Tables\TableTest;
use Granam\Tests\Tools\TestWithMockery;

class RidingAnimalMovementTypesTableTest extends TestWithMockery implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [
                ['movement_type', 'bonus_to_movement_speed', 'fatigue_like']
            ],
            (new RidingAnimalMovementTypesTable(
                $speedTable = new SpeedTable(),
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_values()
    {
        self::assertSame(
            [
                RidingAnimalMovementTypesTable::STILL => [
                    RidingAnimalMovementTypesTable::BONUS_TO_MOVEMENT_SPEED => 0,
                    RidingAnimalMovementTypesTable::FATIGUE_LIKE => MovementTypesTable::WAITING,
                ],
                RidingAnimalMovementTypesTable::GAIT => [
                    RidingAnimalMovementTypesTable::BONUS_TO_MOVEMENT_SPEED => 23,
                    RidingAnimalMovementTypesTable::FATIGUE_LIKE => MovementTypesTable::WALK,
                ],
                RidingAnimalMovementTypesTable::TROT => [
                    RidingAnimalMovementTypesTable::BONUS_TO_MOVEMENT_SPEED => 27,
                    RidingAnimalMovementTypesTable::FATIGUE_LIKE => MovementTypesTable::RUSH,
                ],
                RidingAnimalMovementTypesTable::CANTER => [
                    RidingAnimalMovementTypesTable::BONUS_TO_MOVEMENT_SPEED => 34,
                    RidingAnimalMovementTypesTable::FATIGUE_LIKE => MovementTypesTable::RUN,
                ],
                RidingAnimalMovementTypesTable::GALLOP => [
                    RidingAnimalMovementTypesTable::BONUS_TO_MOVEMENT_SPEED => 39,
                    RidingAnimalMovementTypesTable::FATIGUE_LIKE => MovementTypesTable::SPRINT,
                ],
            ],
            (new RidingAnimalMovementTypesTable(
                $speedTable = new SpeedTable(),
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getIndexedValues()
        );
    }

    /**
     * @test
     * @dataProvider provideMovementAndExpectedBonus
     * @param $ridingAnimalMovement
     * @param $expectedSpeedBonus
     */
    public function I_can_get_speed_bonus($ridingAnimalMovement, $expectedSpeedBonus)
    {
        self::assertEquals(
            new SpeedBonus($expectedSpeedBonus, $speedTable = new SpeedTable()),
            (new RidingAnimalMovementTypesTable(
                $speedTable,
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getSpeedBonus(RidingAnimalMovementCode::getIt($ridingAnimalMovement))
        );
    }

    public function provideMovementAndExpectedBonus()
    {
        return [
            [RidingAnimalMovementCode::STILL, 0],
            [RidingAnimalMovementCode::GALLOP, 39],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_when_still_by_simple_getter()
    {
        self::assertEquals(
            new SpeedBonus(0, $speedTable = new SpeedTable()),
            (new RidingAnimalMovementTypesTable(
                $speedTable,
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getSpeedBonusWhenStill()
        );
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_gait_by_simple_getter()
    {
        self::assertEquals(
            new SpeedBonus(23, $speedTable = new SpeedTable()),
            (new RidingAnimalMovementTypesTable(
                $speedTable,
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getSpeedBonusOnGait()
        );
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_trot_by_simple_getter()
    {
        self::assertEquals(
            new SpeedBonus(27, $speedTable = new SpeedTable()),
            (new RidingAnimalMovementTypesTable(
                $speedTable,
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getSpeedBonusOnTrot()
        );
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_canter_by_simple_getter()
    {
        self::assertEquals(
            new SpeedBonus(34, $speedTable = new SpeedTable()),
            (new RidingAnimalMovementTypesTable(
                $speedTable,
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getSpeedBonusOnCanter()
        );
    }

    /**
     * @test
     */
    public function I_can_get_speed_bonus_on_gallop_by_simple_getter()
    {
        self::assertEquals(
            new SpeedBonus(39, $speedTable = new SpeedTable()),
            (new RidingAnimalMovementTypesTable(
                $speedTable,
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getSpeedBonusOnGallop()
        );
    }

    /**
     * @test
     * @dataProvider provideMovementAndExpectedPeriodOfFatigue
     * @param $movementCode
     * @param Time $period
     */
    public function I_can_get_period_of_point_of_fatigue($movementCode, Time $period)
    {
        self::assertEquals(
            $period,
            (new RidingAnimalMovementTypesTable(
                $speedTable = new SpeedTable(),
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getPeriodForPointOfFatigue(RidingAnimalMovementCode::getIt($movementCode))
        );
    }

    public function provideMovementAndExpectedPeriodOfFatigue()
    {
        $movementTypesTable = new MovementTypesTable(new SpeedTable(), new TimeTable());

        return [
            [RidingAnimalMovementCode::CANTER, $movementTypesTable->getPeriodForPointOfFatigueOnRun()],
            [RidingAnimalMovementCode::GALLOP, $movementTypesTable->getPeriodForPointOfFatigueOnSprint()]
        ];
    }

    /**
     * @test
     */
    public function I_can_get_period_of_point_of_fatigue_for_gait()
    {
        self::assertEquals(
            new Time(1, Time::HOUR, new TimeTable()),
            (new RidingAnimalMovementTypesTable(
                $speedTable = new SpeedTable(),
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getPeriodForPointOfFatigueOnGait()
        );
    }

    /**
     * @test
     */
    public function I_can_get_period_of_point_of_fatigue_for_trot()
    {
        self::assertEquals(
            new Time(0.5, Time::HOUR, new TimeTable()),
            (new RidingAnimalMovementTypesTable(
                $speedTable = new SpeedTable(),
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getPeriodForPointOfFatigueOnTrot()
        );
    }

    /**
     * @test
     */
    public function I_can_get_period_of_point_of_fatigue_for_canter()
    {
        self::assertEquals(
            new Time(5, Time::MINUTE, new TimeTable()),
            (new RidingAnimalMovementTypesTable(
                $speedTable = new SpeedTable(),
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getPeriodForPointOfFatigueOnCanter()
        );
    }

    /**
     * @test
     */
    public function I_can_get_period_of_point_of_fatigue_for_gallop()
    {
        self::assertEquals(
            new Time(2, Time::ROUND, new TimeTable()),
            (new RidingAnimalMovementTypesTable(
                $speedTable = new SpeedTable(),
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getPeriodForPointOfFatigueOnGallop()
        );
    }

    /**
     * @test
     */
    public function I_can_get_maximum_time_bonus_to_gallop()
    {
        $speedTable = new SpeedTable();
        $timeTable = new TimeTable();
        $movementTypesTable = new MovementTypesTable($speedTable, $timeTable);
        $endurance = $this->createEndurance(12);

        self::assertEquals(
            $movementTypesTable->getMaximumTimeBonusToSprint($endurance),
            (new RidingAnimalMovementTypesTable(
                $speedTable,
                $timeTable,
                new MovementTypesTable($speedTable, $timeTable)
            ))->getMaximumTimeBonusToGallop($endurance)
        );
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

    /**
     * @test
     */
    public function I_can_get_required_time_bonus_to_walk_after_full_gallop()
    {
        $speedTable = new SpeedTable();
        $timeTable = new TimeTable();
        $movementTypesTable = new MovementTypesTable($speedTable, $timeTable);
        $endurance = $this->createEndurance(12);

        self::assertEquals(
            $movementTypesTable->getRequiredTimeBonusToWalkAfterFullSprint($endurance),
            (new RidingAnimalMovementTypesTable(
                $speedTable = new SpeedTable(),
                $timeTable = new TimeTable(),
                new MovementTypesTable($speedTable, $timeTable)
            ))->getRequiredTimeBonusToWalkAfterFullGallop($endurance)
        );
    }

}