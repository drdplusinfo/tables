<?php
namespace DrdPlus\Tables\Measurements\Speed;

use DrdPlus\Codes\SpeedUnitCode;
use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementFileTable;
use DrdPlus\Tables\Measurements\Tools\DummyEvaluator;
use Granam\Integer\IntegerInterface;

/**
 * See PPH page 163, @link https://pph.drdplus.jaroslavtyc.com/#tabulka_rychlosti
 */
class SpeedTable extends AbstractMeasurementFileTable
{
    public function __construct()
    {
        parent::__construct(new DummyEvaluator());
    }

    /**
     * @return string
     */
    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/speed.csv';
    }

    /**
     * @return array|string[]
     */
    protected function getExpectedDataHeader(): array
    {
        return [SpeedUnitCode::METERS_PER_ROUND, SpeedUnitCode::KILOMETERS_PER_HOUR];
    }

    /**
     * @param int|IntegerInterface $bonusValue
     * @return SpeedBonus
     * @throws \DrdPlus\Tables\Measurements\Partials\Exceptions\BonusRequiresInteger
     */
    protected function createBonus($bonusValue)
    {
        return new SpeedBonus($bonusValue, $this);
    }

    /**
     * @param SpeedBonus $bonus
     * @param string|null $wantedUnit
     * @return Speed|MeasurementWithBonus
     */
    public function toSpeed(SpeedBonus $bonus, $wantedUnit = null)
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->toMeasurement($bonus, $wantedUnit);
    }

    /**
     * @param Speed $speed
     * @return SpeedBonus|AbstractBonus
     */
    public function toBonus(Speed $speed)
    {
        return $this->measurementToBonus($speed);
    }

    /**
     * @param float $value
     * @param string $unit
     * @return Speed
     */
    protected function convertToMeasurement($value, $unit)
    {
        return new Speed($value, $unit, $this);
    }

}