<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Fatigue;

use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementWithBonus;
use Granam\Integer\Tools\ToInteger;

/**
 * @method int getValue()
 * @see Fatigue::normalizeValue()
 */
class Fatigue extends AbstractMeasurementWithBonus
{
    const FATIGUE = 'fatigue';

    /**
     * @var FatigueTable
     */
    private $fatigueTable;

    /**
     * @param float|\Granam\Float\FloatInterface|\Granam\Integer\IntegerInterface|int $value
     * @param \Granam\String\StringInterface|string $unit
     * @param FatigueTable $fatigueTable
     * @throws \DrdPlus\Tables\Measurements\Exceptions\UnknownUnit
     * @throws \Granam\Float\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Float\Tools\Exceptions\ValueLostOnCast
     * @throws \Granam\Scalar\Tools\Exceptions\WrongParameterType
     */
    public function __construct($value, $unit, FatigueTable $fatigueTable)
    {
        parent::__construct($value, $unit);
        $this->fatigueTable = $fatigueTable;
    }

    /**
     * @param mixed $value
     * @return int
     * @throws \Granam\Integer\Tools\Exceptions\WrongParameterType
     * @throws \Granam\Integer\Tools\Exceptions\ValueLostOnCast
     */
    protected function normalizeValue($value): int
    {
        return ToInteger::toInteger($value);
    }

    /**
     * @return array|string[]
     */
    public function getPossibleUnits(): array
    {
        return [self::FATIGUE];
    }

    /**
     * @return FatigueBonus
     */
    public function getBonus(): FatigueBonus
    {
        return $this->fatigueTable->toBonus($this);
    }

}