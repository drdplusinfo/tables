<?php
namespace DrdPlus\Tests\Tables\Equipment\Riding;

use DrdPlus\Tables\Body\MovementTypes\MovementTypesTable;
use DrdPlus\Tables\Equipment\Riding\RidingAnimalMovementTypesTable;
use DrdPlus\Tables\Measurements\Speed\SpeedTable;
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

}
