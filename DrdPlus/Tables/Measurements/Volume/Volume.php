<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Volume;

use DrdPlus\Codes\Units\VolumeUnitCode;
use DrdPlus\Tables\Measurements\Exceptions\UnknownUnit;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementWithBonus;
use Granam\Tools\ValueDescriber;

class Volume extends AbstractMeasurementWithBonus
{
    const LITER = VolumeUnitCode::LITER;
    const CUBIC_METER = VolumeUnitCode::CUBIC_METER;
    const CUBIC_KILOMETER = VolumeUnitCode::CUBIC_KILOMETER;

    /** @var VolumeTable */
    private $volumeTable;

    public function __construct(float $value, string $unit, VolumeTable $volumeTable)
    {
        parent::__construct($value, $unit);
        $this->volumeTable = $volumeTable;
    }

    public function getPossibleUnits(): array
    {
        return [self::LITER, self::CUBIC_METER, self::CUBIC_KILOMETER];
    }

    public function getBonus(): VolumeBonus
    {
        return $this->volumeTable->toBonus($this);
    }

    public function getUnitCode(): VolumeUnitCode
    {
        return VolumeUnitCode::getIt($this->getUnit());
    }

    public function getLiters(): float
    {
        return $this->getValueInDifferentUnit(self::LITER);
    }

    /**
     * @param string $toUnit
     * @return float
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     */
    private function getValueInDifferentUnit(string $toUnit): float
    {
        if ($this->getUnit() === $toUnit) {
            return $this->getValue();
        }
        switch ($this->getUnit()) {
            case self::LITER :
                if ($toUnit === self::CUBIC_METER) {
                    return $this->getValue() / (10 ** 3);
                }
                if ($toUnit === self::CUBIC_KILOMETER) {
                    return $this->getValue() / (10000 ** 3);
                }
                break;
            case self::CUBIC_METER :
                if ($toUnit === self::CUBIC_KILOMETER) {
                    return $this->getValue() / (1000 ** 3);
                }
                if ($toUnit === self::LITER) {
                    return $this->getValue() * 1000;
                }
                break;
            case self::CUBIC_KILOMETER :
                if ($toUnit === self::CUBIC_METER) {
                    return $this->getValue() * (1000 ** 3);
                }
                if ($toUnit === self::LITER) {
                    return $this->getValue() * (10000 ** 3);
                }
                break;
        }
        throw new UnknownUnit(
            'Unknown one or both from ' . ValueDescriber::describe($this->getUnit())
            . ' to ' . ValueDescriber::describe($toUnit) . ' unit(s)'
        );
    }

    public function getCubicMeters(): float
    {
        return $this->getValueInDifferentUnit(self::CUBIC_METER);
    }

    public function getCubicKilometers(): float
    {
        return $this->getValueInDifferentUnit(self::CUBIC_KILOMETER);
    }
}