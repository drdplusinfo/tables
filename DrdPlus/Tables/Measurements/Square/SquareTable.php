<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Square;

use DrdPlus\Codes\Units\SquareUnitCode;
use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementFileTable;
use DrdPlus\Tables\Measurements\Tools\DummyEvaluator;

/**
 * See PPH @link https://pph.drdplus.info/tabulka_objemu
 */
class SquareTable extends AbstractMeasurementFileTable
{
    public function __construct()
    {
        parent::__construct(new DummyEvaluator());
    }

    protected function getExpectedDataHeader(): array
    {
        return [
            SquareUnitCode::SQUARE_DECIMETER,
            SquareUnitCode::SQUARE_METER,
            SquareUnitCode::SQUARE_KILOMETER,
        ];
    }

    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/square.csv';
    }

    /**
     * @param int $bonusValue
     * @return AbstractBonus|SquareBonus
     */
    protected function createBonus(int $bonusValue): AbstractBonus
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new SquareBonus($bonusValue, $this);
    }

    /**
     * @param float $value
     * @param string $unit
     * @return MeasurementWithBonus|Square
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     */
    protected function convertToMeasurement(float $value, string $unit): MeasurementWithBonus
    {
        return new Square($value, $unit, $this);
    }

    /**
     * @param Square $square
     * @return SquareBonus|AbstractBonus
     */
    public function toBonus(Square $square): SquareBonus
    {
        return $this->measurementToBonus($square);
    }

    /**
     * @param SquareBonus $squareBonus
     * @return MeasurementWithBonus|Square
     */
    public function toSquare(SquareBonus $squareBonus): Square
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->toMeasurement($squareBonus);
    }
}