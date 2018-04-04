<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Measurements\Square;

use DrdPlus\Codes\Units\SquareUnitCode;
use DrdPlus\Tables\Measurements\Square\Square;
use DrdPlus\Tables\Measurements\Square\SquareTable;
use DrdPlus\Tests\Tables\Measurements\AbstractTestOfMeasurement;
use Granam\String\StringTools;

class SquareTest extends AbstractTestOfMeasurement
{
    protected function getDefaultUnit(): string
    {
        return SquareUnitCode::SQUARE_METER;
    }

    public function getAllUnits(): array
    {
        return SquareUnitCode::getPossibleValues();
    }

    /**
     * @test
     */
    public function I_can_get_unit_as_a_code_instance(): void
    {
        $squareTable = new SquareTable();
        foreach ($this->getAllUnits() as $unitName) {
            $square = new Square(123.456, $unitName, $squareTable);
            self::assertSame(SquareUnitCode::getIt($unitName), $square->getUnitCode());
        }
    }

    /**
     * @test
     */
    public function I_can_get_it_in_every_unit_by_specific_getter(): void
    {
        $squareTable = new SquareTable();

        $squareDecimeterToSquareMeter = 10 ** -2;
        $squareMeterToSquareKilometer = 10 ** -6;
        $squareDecimeterToSquareKilometer = $squareDecimeterToSquareMeter * $squareMeterToSquareKilometer;

        $squareDecimeters = new Square($value = 10, $unit = SquareUnitCode::SQUARE_DECIMETER, $squareTable);
        self::assertSame((float)$value, $squareDecimeters->getValue());
        self::assertSame($unit, $squareDecimeters->getUnit());
        self::assertSame((float)$value * $squareDecimeterToSquareMeter, $squareDecimeters->getSquareMeters());
        self::assertSame((float)($value * $squareDecimeterToSquareKilometer), $squareDecimeters->getSquareKilometers());
        self::assertSame(-20, $squareDecimeters->getBonus()->getValue(), "Expected different bonus for square {$squareDecimeters}");

        $squareMeters = new Square($value = 456, $unit = SquareUnitCode::SQUARE_METER, $squareTable);
        self::assertSame((float)$value, $squareMeters->getValue());
        self::assertSame($unit, $squareMeters->getUnit());
        self::assertSame((float)$value / $squareDecimeterToSquareMeter, $squareMeters->getSquareDecimeters());
        self::assertSame((float)$value, $squareMeters->getSquareMeters());
        self::assertSame((float)($value * $squareMeterToSquareKilometer), $squareMeters->getSquareKilometers());
        self::assertSame(53, $squareMeters->getBonus()->getValue());

        $squareKilometers = new Square($value = 0.9, $unit = SquareUnitCode::SQUARE_KILOMETER, $squareTable);
        self::assertSame($value, $squareKilometers->getValue());
        self::assertSame($unit, $squareKilometers->getUnit());
        self::assertSame($value, $squareKilometers->getSquareKilometers());
        self::assertSame(round($value / $squareMeterToSquareKilometer), $squareKilometers->getSquareMeters());
        self::assertSame(round($value / $squareDecimeterToSquareKilometer), $squareKilometers->getSquareDecimeters());
        self::assertSame(119, $squareKilometers->getBonus()->getValue(), "Expected different bonus for square {$squareKilometers}");
    }

    /**
     * @test
     * @dataProvider provideInSpecificUnitGetters
     * @expectedException \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     * @expectedExceptionMessageRegExp ~drop~
     * @param string $getInUnit
     */
    public function Can_not_cast_it_from_unknown_unit(string $getInUnit): void
    {
        /** @var Square|\Mockery\MockInterface $squareWithInvalidUnit */
        $squareWithInvalidUnit = $this->mockery(Square::class);
        $squareWithInvalidUnit->shouldReceive('getUnit')
            ->andReturn('drop');
        $squareWithInvalidUnit->makePartial();
        $squareWithInvalidUnit->$getInUnit();
    }

    public function provideInSpecificUnitGetters(): array
    {
        $getters = [];
        foreach (SquareUnitCode::getPossibleValues() as $squareUnit) {
            // like getMeters
            $getters[] = [StringTools::assembleGetterForName($squareUnit . 's' /* plural */)];
        }

        return $getters;
    }

    /**
     * @test
     * @dataProvider provideSquareUnits
     * @expectedException \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     * @expectedExceptionMessageRegExp ~first~
     * @param string $unit
     * @throws \ReflectionException
     */
    public function Can_not_cast_it_to_unknown_unit(string $unit): void
    {
        $square = new \ReflectionClass(Square::class);
        $getValueInDifferentUnit = $square->getMethod('getValueInDifferentUnit');
        $getValueInDifferentUnit->setAccessible(true);
        $getValueInDifferentUnit->invoke(new Square(123, $unit, new SquareTable()), 'first');
    }

    public function provideSquareUnits()
    {
        return array_map(
            function (string $squareUnit) {
                return [$squareUnit]; // just wrapped by an array to satisfy required PHPUnit format
            },
            SquareUnitCode::getPossibleValues()
        );
    }

}