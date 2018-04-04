<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Measurements\Square;

use DrdPlus\Codes\Units\SquareUnitCode;
use DrdPlus\Tables\Measurements\Square\Square;
use DrdPlus\Tables\Measurements\Square\SquareBonus;
use DrdPlus\Tables\Measurements\Square\SquareTable;
use DrdPlus\Tests\Tables\Measurements\MeasurementTableTest;

class SquareTableTest extends MeasurementTableTest
{
    /**
     * @test
     */
    public function I_can_convert_bonus_to_value(): void
    {
        $squareTable = new SquareTable();

        $squareMeterToKilometer = 1000 ** 2;
        $bonus = new SquareBonus(-40, $squareTable);
        $square = $squareTable->toSquare($bonus);
        self::assertSame(0.01, $square->getSquareMeters(), "Expected 0.01 as square in meters from bonus {$bonus}");
        self::assertSame(0.01 / $squareMeterToKilometer, $square->getSquareKilometers());
        self::assertSame($bonus->getValue(), $square->getBonus()->getValue());

        $bonus = new SquareBonus(0, $squareTable);
        $square = $squareTable->toSquare($bonus);
        self::assertSame(1.0, $square->getSquareMeters());
        self::assertSame(1.0 / $squareMeterToKilometer, $square->getSquareKilometers());
        self::assertSame($bonus->getValue(), $square->getBonus()->getValue());

        $bonus = new SquareBonus(119, $squareTable);
        $square = $squareTable->toSquare($bonus);
        self::assertSame(0.9 * $squareMeterToKilometer, $square->getSquareMeters(), "Expected 0.9 * {$squareMeterToKilometer} as square in meters");
        self::assertSame(0.9, $square->getSquareKilometers());
        self::assertSame($bonus->getValue(), $square->getBonus()->getValue());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Partials\Exceptions\UnknownBonus
     */
    public function I_can_not_use_too_low_bonus_to_value(): void
    {
        $distanceTable = new SquareTable();
        $distanceTable->toSquare(new SquareBonus(-41, $distanceTable));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Partials\Exceptions\UnknownBonus
     */
    public function I_can_not_convert_too_high_bonus_into_too_detailed_unit(): void
    {
        $distanceTable = new SquareTable();
        $distanceTable->toSquare(new SquareBonus(120, $distanceTable));
    }

    /**
     * @test
     */
    public function I_can_convert_value_to_bonus(): void
    {
        $distanceTable = new SquareTable();

        // 0.01 matches more bonuses - the lowest is taken
        $distance = new Square(0.01, SquareUnitCode::SQUARE_METER, $distanceTable);
        self::assertSame(-40, $distance->getBonus()->getValue());

        $distance = new Square(1, SquareUnitCode::SQUARE_METER, $distanceTable);
        self::assertSame(0, $distance->getBonus()->getValue());
        $distance = new Square(1.5, SquareUnitCode::SQUARE_METER, $distanceTable);
        self::assertSame(4, $distance->getBonus()->getValue());

        $distance = new Square(104, SquareUnitCode::SQUARE_METER, $distanceTable);
        self::assertSame(40, $distance->getBonus()->getValue()); // 40 is the closest bonus
        $distance = new Square(105, SquareUnitCode::SQUARE_METER, $distanceTable);
        self::assertSame(41, $distance->getBonus()->getValue()); // 40 and 41 are closest bonuses, 41 is taken because higher
        $distance = new Square(106, SquareUnitCode::SQUARE_METER, $distanceTable);
        self::assertSame(41, $distance->getBonus()->getValue()); // 41 is the closest bonus (higher in this case)

        $distance = new Square(0.9, SquareUnitCode::SQUARE_KILOMETER, $distanceTable);
        self::assertSame(119, $distance->getBonus()->getValue(), "Expected different bonus for distance {$distance}");
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Partials\Exceptions\RequestedDataOutOfTableRange
     */
    public function I_can_not_convert_too_low_value_to_bonus(): void
    {
        $distanceTable = new SquareTable();
        $distance = new Square(0.009, SquareUnitCode::SQUARE_METER, $distanceTable);
        $distance->getBonus();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Measurements\Partials\Exceptions\RequestedDataOutOfTableRange
     */
    public function I_can_not_convert_too_high_value_to_bonus(): void
    {
        $distanceTable = new SquareTable();
        $distance = new Square(901, SquareUnitCode::SQUARE_KILOMETER, $distanceTable);
        $distance->getBonus();
    }
}