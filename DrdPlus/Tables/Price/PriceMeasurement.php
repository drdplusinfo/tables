<?php
namespace DrdPlus\Tables\Fatigue;

use DrdPlus\Tables\AbstractMeasurement;

class PriceMeasurement extends AbstractMeasurement
{
    const COPPER_COIN = 'copper_coin';
    const SILVER_COIN = 'silver_coin';
    const GOLD_COIN = 'gold_coin';

    private $inDifferentUnit = [];

    /**
     * @param float $value
     * @param string $unit
     */
    public function __construct($value, $unit)
    {
        parent::__construct($value, $unit);
    }

    public function getPossibleUnits()
    {
        return array_merge([self::COPPER_COIN, self::SILVER_COIN, self::GOLD_COIN], array_keys($this->inDifferentUnit));
    }

    /**
     * @param float $value
     * @param string $unit
     */
    public function addInDifferentUnit($value, $unit)
    {
        throw new \LogicException('Not supported');
    }

    public function toCopperCoins()
    {
        if ($this->getUnit() === self::COPPER_COIN) {
            return $this->getValue();
        }
        if ($this->getUnit() === self::SILVER_COIN) {
            return $this->getValue() * 10;
        }
        if ($this->getUnit() === self::GOLD_COIN) {
            return $this->getValue() * 100;
        }
        throw new \LogicException("Can't convert {$this->getUnit()} to " . self::COPPER_COIN);
    }

    public function toSilverCoins()
    {
        if ($this->getUnit() === self::COPPER_COIN) {
            return $this->getValue() / 10;
        }
        if ($this->getUnit() === self::SILVER_COIN) {
            return $this->getValue();
        }
        if ($this->getUnit() === self::GOLD_COIN) {
            return $this->getValue() * 10;
        }
        throw new \LogicException("Can't convert {$this->getUnit()} to " . self::SILVER_COIN);
    }

    public function toGoldCoins()
    {
        if ($this->getUnit() === self::COPPER_COIN) {
            return $this->getValue() / 100;
        }
        if ($this->getUnit() === self::SILVER_COIN) {
            return $this->getValue() / 10;
        }
        if ($this->getUnit() === self::GOLD_COIN) {
            return $this->getValue();
        }
        throw new \LogicException("Can't convert {$this->getUnit()} to " . self::GOLD_COIN);
    }

}
