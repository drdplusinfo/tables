<?php
namespace DrdPlus\Tables\Measurements\Price;

use DrdPlus\Tables\Measurements\Exceptions\UnknownUnit;
use DrdPlus\Tables\Measurements\Parts\AbstractMeasurement;

class Price extends AbstractMeasurement
{
    const COPPER_COIN = 'copper_coin';
    const SILVER_COIN = 'silver_coin';
    const GOLD_COIN = 'gold_coin';

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
        return [self::COPPER_COIN, self::SILVER_COIN, self::GOLD_COIN];
    }

    /**
     * @return int
     * @noinspection PhpInconsistentReturnPointsInspection
     */
    public function getCopperCoins()
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

    /**
     * @return float
     * @noinspection PhpInconsistentReturnPointsInspection
     */
    public function getSilverCoins()
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

    /**
     * @return float
     * @noinspection PhpInconsistentReturnPointsInspection
     */
    public function getGoldCoins()
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
