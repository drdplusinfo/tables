<?php
namespace DrdPlus\Tests\Tables\Equipment\Riding;

use DrdPlus\Codes\RidingAnimalMovementCode;
use DrdPlus\Tables\Equipment\Riding\Ride;
use DrdPlus\Tables\Equipment\Riding\RidesTable;
use DrdPlus\Tests\Tables\TableTest;
use Granam\Tests\Tools\TestWithMockery;

class RidesTableTest extends TestWithMockery implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        self::assertSame(
            [
                ['movement_type', 'ride', 'additional']
            ],
            (new RidesTable())->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_all_values()
    {
        self::assertSame(
            [
                RidingAnimalMovementCode::STILL => [
                    RidesTable::RIDE => -2,
                    RidesTable::ADDITIONAL => false
                ],
                RidingAnimalMovementCode::GAIT => [
                    RidesTable::RIDE => 0,
                    RidesTable::ADDITIONAL => false
                ],
                RidingAnimalMovementCode::TROT => [
                    RidesTable::RIDE => 2,
                    RidesTable::ADDITIONAL => false
                ],
                RidingAnimalMovementCode::CANTER => [
                    RidesTable::RIDE => 4,
                    RidesTable::ADDITIONAL => false
                ],
                RidingAnimalMovementCode::GALLOP => [
                    RidesTable::RIDE => 6,
                    RidesTable::ADDITIONAL => false
                ],
                RidingAnimalMovementCode::JUMPING => [
                    RidesTable::RIDE => 2,
                    RidesTable::ADDITIONAL => true
                ],
            ],
            (new RidesTable())->getIndexedValues()
        );
    }

    /**
     * @test
     * @dataProvider provideMovementAndExpectedRide
     * @param string $movement
     * @param bool $jumping
     * @param int $expectedRideValue
     */
    public function I_can_get_ride_for_any_move($movement, $jumping, $expectedRideValue)
    {
        $ridesTable = new RidesTable();
        self::assertEquals(
            new Ride($expectedRideValue),
            $ridesTable->getRideFor(RidingAnimalMovementCode::getIt($movement), $jumping)
        );
    }

    public function provideMovementAndExpectedRide()
    {
        return [
            [RidingAnimalMovementCode::STILL, false, -2],
            [RidingAnimalMovementCode::STILL, true, 0], // horse can jump from place
            [RidingAnimalMovementCode::GAIT, false, 0],
            [RidingAnimalMovementCode::GAIT, true, 2],
            [RidingAnimalMovementCode::TROT, false, 2],
            [RidingAnimalMovementCode::TROT, true, 4],
            [RidingAnimalMovementCode::CANTER, false, 4],
            [RidingAnimalMovementCode::CANTER, true, 6],
            [RidingAnimalMovementCode::GALLOP, false, 6],
            [RidingAnimalMovementCode::GALLOP, true, 8],
        ];
    }
}
