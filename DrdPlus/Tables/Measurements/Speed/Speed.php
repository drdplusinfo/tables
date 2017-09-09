<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Speed;

use DrdPlus\Codes\Units\SpeedUnitCode;
use DrdPlus\Tables\Measurements\Distance\Distance;
use DrdPlus\Tables\Measurements\Distance\DistanceTable;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementWithBonus;

class Speed extends AbstractMeasurementWithBonus
{
    const METER_PER_ROUND = SpeedUnitCode::METER_PER_ROUND;
    const KILOMETER_PER_HOUR = SpeedUnitCode::KILOMETER_PER_HOUR;

    /**
     * @var SpeedTable
     */
    private $speedTable;

    /**
     * @param float $value
     * @param SpeedTable $speedTable
     * @param string $unit
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function __construct($value, $unit, SpeedTable $speedTable)
    {
        $this->speedTable = $speedTable;
        parent::__construct($value, $unit);
    }

    /**
     * @return array|string[]
     */
    public function getPossibleUnits(): array
    {
        return [self::METER_PER_ROUND, self::KILOMETER_PER_HOUR];
    }

    /**
     * @return float
     */
    public function getMetersPerRound(): float
    {
        return $this->convertTo(self::METER_PER_ROUND);
    }

    /**
     * @param string $wantedUnit
     * @return float
     */
    private function convertTo($wantedUnit): float
    {
        if ($this->getUnit() === $wantedUnit) {
            return $this->getValue();
        }

        return $this->getBonus()->getSpeed(self::KILOMETER_PER_HOUR)->getValue();
    }

    /**
     * @return float
     */
    public function getKilometersPerHour(): float
    {
        return $this->convertTo(self::KILOMETER_PER_HOUR);
    }

    /**
     * @return SpeedBonus
     */
    public function getBonus(): SpeedBonus
    {
        return $this->speedTable->toBonus($this);
    }

    /**
     * @param DistanceTable $distanceTable
     * @return Distance
     */
    public function getDistancePerRound(DistanceTable $distanceTable): Distance
    {
        return $this->getBonus()->getDistancePerRound($distanceTable);
    }

    /**
     * @return SpeedUnitCode
     */
    public function getUnitCode(): SpeedUnitCode
    {
        return SpeedUnitCode::getIt($this->getUnit());
    }
}