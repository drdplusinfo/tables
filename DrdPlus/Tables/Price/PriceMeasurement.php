<?php
namespace DrdPlus\Tables\Price;

use DrdPlus\Tables\AbstractMeasurement;
use DrdPlus\Tables\Exceptions\UnknownUnit;

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
        return array_merge(
            [self::COPPER_COIN, self::SILVER_COIN, self::GOLD_COIN],
            array_keys($this->inDifferentUnit)
        );
    }

    /**
     * @param float $value
     * @param string $unit
     */
    public function addInDifferentUnit($value, $unit)
    {
        $this->checkValueInDifferentUnit($value, $unit);
        $expectedValue = false;
        switch ($unit) {
            case $this->getUnit() :
                break;
            case self::COPPER_COIN :
                $expectedValue = $this->toCopperCoins();
                break;
            case self::SILVER_COIN :
                $expectedValue = $this->toSilverCoins();
                break;
            case self::GOLD_COIN :
                $expectedValue = $this->toGoldCoins();
                break;
        }
        if (is_numeric($expectedValue) && $expectedValue !== (float)$value) {
            throw new Exceptions\IncorrectAmount(
                "Expected $expectedValue for $unit, got $value"
            );
        }
    }

    /** @noinspection PhpInconsistentReturnPointsInspection */
    public function toCopperCoins()
    {
        switch ($this->getUnit()) {
            case (self::COPPER_COIN) :
                return $this->getValue();
            case (self::SILVER_COIN) :
                return $this->getValue() * 10;
            case (self::GOLD_COIN) :
                return $this->getValue() * 100;
            default :
                throw new UnknownUnit('Unknown unit ' . $this->getUnit());
        }
    }

    /** @noinspection PhpInconsistentReturnPointsInspection */
    public function toSilverCoins()
    {
        switch ($this->getUnit()) {
            case (self::COPPER_COIN) :
                return $this->getValue() / 10;
            case (self::SILVER_COIN) :
                return $this->getValue();
            case (self::GOLD_COIN) :
                return $this->getValue() * 10;
            default :
                throw new UnknownUnit('Unknown unit ' . $this->getUnit());
        }
    }

    /** @noinspection PhpInconsistentReturnPointsInspection */
    public function toGoldCoins()
    {
        switch ($this->getUnit()) {
            case (self::COPPER_COIN) :
                return $this->getValue() / 100;
            case (self::SILVER_COIN) :
                return $this->getValue() / 10;
            case (self::GOLD_COIN) :
                return $this->getValue();
            default :
                throw new UnknownUnit('Unknown unit ' . $this->getUnit());
        }
    }

}
