<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tables\Measurements\Volume;

use DrdPlus\Codes\Units\VolumeUnitCode;
use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractBonus;
use DrdPlus\Tables\Measurements\Partials\AbstractMeasurementFileTable;
use DrdPlus\Tables\Measurements\Tools\DummyEvaluator;

/**
 * See PPH @link https://pph.drdplus.info/tabulka_objemu
 */
class VolumeTable extends AbstractMeasurementFileTable
{
    public function __construct()
    {
        parent::__construct(new DummyEvaluator());
    }

    protected function getExpectedDataHeader(): array
    {
        return [
            VolumeUnitCode::LITER,
            VolumeUnitCode::CUBIC_METER,
            VolumeUnitCode::CUBIC_KILOMETER,
        ];
    }

    protected function getDataFileName(): string
    {
        return __DIR__ . '/data/volume.csv';
    }

    /**
     * @param int $bonusValue
     * @return AbstractBonus|VolumeBonus
     */
    protected function createBonus(int $bonusValue): AbstractBonus
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return new VolumeBonus($bonusValue, $this);
    }

    /**
     * @param float $value
     * @param string $unit
     * @return MeasurementWithBonus|Volume
     */
    protected function convertToMeasurement(float $value, string $unit): MeasurementWithBonus
    {
        return new Volume($value, $unit, $this);
    }

    /**
     * @param Volume $volume
     * @return VolumeBonus|AbstractBonus
     */
    public function toBonus(Volume $volume): VolumeBonus
    {
        return $this->measurementToBonus($volume);
    }

    /**
     * @param VolumeBonus $volumeBonus
     * @return MeasurementWithBonus|Volume
     */
    public function toVolume(VolumeBonus $volumeBonus): Volume
    {
        /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
        return $this->toMeasurement($volumeBonus);
    }
}