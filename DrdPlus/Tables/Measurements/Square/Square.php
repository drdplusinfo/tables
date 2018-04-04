<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Square;

use DrdPlus\Codes\Units\SquareUnitCode;
use DrdPlus\Tables\Measurements\Exceptions\UnknownUnit;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementWithBonus;
use Granam\Tools\ValueDescriber;

class Square extends AbstractMeasurementWithBonus
{
    public const SQUARE_DECIMETER = SquareUnitCode::SQUARE_DECIMETER;
    public const SQUARE_METER = SquareUnitCode::SQUARE_METER;
    public const SQUARE_KILOMETER = SquareUnitCode::SQUARE_KILOMETER;

    /** @var SquareTable */
    private $volumeTable;

    /**
     * @param float $value
     * @param string $unit
     * @param SquareTable $squareTable
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     */
    public function __construct(float $value, string $unit, SquareTable $squareTable)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        parent::__construct($value, $unit);
        $this->volumeTable = $squareTable;
    }

    public function getPossibleUnits(): array
    {
        return [self::SQUARE_DECIMETER, self::SQUARE_METER, self::SQUARE_KILOMETER];
    }

    public function getBonus(): SquareBonus
    {
        return $this->volumeTable->toBonus($this);
    }

    public function getUnitCode(): SquareUnitCode
    {
        return SquareUnitCode::getIt($this->getUnit());
    }

    public function getSquareDecimeters(): float
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueInDifferentUnit(self::SQUARE_DECIMETER);
    }

    /**
     * @param string $toUnit
     * @return float
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     */
    private function getValueInDifferentUnit(string $toUnit): float
    {
        if ($this->getUnit() === $toUnit) {
            return $this->getValue();
        }
        switch ($this->getUnit()) {
            case self::SQUARE_DECIMETER :
                if ($toUnit === self::SQUARE_METER) {
                    return $this->getValue() / (10 ** 2);
                }
                if ($toUnit === self::SQUARE_KILOMETER) {
                    return $this->getValue() / ((10 * 1000) ** 2);
                }
                break;
            case self::SQUARE_METER :
                if ($toUnit === self::SQUARE_KILOMETER) {
                    return $this->getValue() / (1000 ** 2);
                }
                if ($toUnit === self::SQUARE_DECIMETER) {
                    return $this->getValue() * (10 ** 2);
                }
                break;
            case self::SQUARE_KILOMETER :
                if ($toUnit === self::SQUARE_METER) {
                    return $this->getValue() * (1000 ** 2);
                }
                if ($toUnit === self::SQUARE_DECIMETER) {
                    return $this->getValue() * ((10 * 1000) ** 2);
                }
                break;
        }
        throw new UnknownUnit(
            'Unknown one or both from ' . ValueDescriber::describe($this->getUnit())
            . ' to ' . ValueDescriber::describe($toUnit) . ' unit(s)'
        );
    }

    public function getSquareMeters(): float
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueInDifferentUnit(self::SQUARE_METER);
    }

    public function getSquareKilometers(): float
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->getValueInDifferentUnit(self::SQUARE_KILOMETER);
    }
}