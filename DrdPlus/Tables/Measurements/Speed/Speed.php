<?php
namespace DrdPlus\Tables\Measurements\Speed;

use DrdPlus\Tables\Measurements\Distance\DistanceTable;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementWithBonus;

class Speed extends AbstractMeasurementWithBonus
{

    const M_PER_ROUND = 'm/round';
    const KM_PER_HOUR = 'km/h';

    /**
     * @var SpeedTable
     */
    private $speedTable;

    /**
     * @param float $value
     * @param SpeedTable $speedTable
     * @param string $unit
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
        return [self::M_PER_ROUND, self::KM_PER_HOUR];
    }

    /**
     * @return float
     */
    public function getMetersPerRound()
    {
        return $this->convertTo(self::M_PER_ROUND);
    }

    /**
     * @param string $wantedUnit
     *
     * @return float
     */
    private function convertTo($wantedUnit)
    {
        if ($this->getUnit() === $wantedUnit) {
            return $this->getValue();
        }

        return $this->getBonus()->getSpeed(self::KM_PER_HOUR)->getValue();
    }

    /**
     * @return float
     */
    public function getKilometersPerHour()
    {
        return $this->convertTo(self::KM_PER_HOUR);
    }

    /**
     * @return SpeedBonus
     */
    public function getBonus()
    {
        return $this->speedTable->toBonus($this);
    }

    /**
     * @param DistanceTable $distanceTable
     * @return \DrdPlus\Tables\Measurements\Distance\Distance
     */
    public function getDistancePerRound(DistanceTable $distanceTable)
    {
        return $this->getBonus()->getDistancePerRound($distanceTable);
    }
}
