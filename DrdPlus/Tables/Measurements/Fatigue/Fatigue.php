<?php
namespace DrdPlus\Tables\Measurements\Fatigue;

use DrdPlus\Tables\Measurements\Parts\AbstractMeasurementWithBonus;
use Granam\Integer\Tools\ToInteger;

/**
 * @method int getValue()
 * @see \DrdPlus\Tables\Measurements\Fatigue\Fatigue::normalizeValue
 */
class Fatigue extends AbstractMeasurementWithBonus
{
    const FATIGUE = 'fatigue';

    /**
     * @var FatigueTable
     */
    private $fatigueTable;

    public function __construct($value, $unit, FatigueTable $fatigueTable)
    {
        parent::__construct($value, $unit);
        $this->fatigueTable = $fatigueTable;
    }

    /**
     * @param mixed $value
     *
     * @return int
     */
    protected function normalizeValue($value)
    {
        return ToInteger::toInteger($value);
    }

    /**
     * @return array|string[]
     */
    public function getPossibleUnits()
    {
        return [self::FATIGUE];
    }

    /**
     * @return FatigueBonus
     */
    public function getBonus()
    {
        return $this->fatigueTable->toBonus($this);
    }

}
