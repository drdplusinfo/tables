<?php
namespace DrdPlus\Tests\Tables\Price;

use DrdPlus\Tables\Price\Price;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class PriceTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return Price::COPPER_COIN;
    }

    public function getAllUnits()
    {
        return [Price::COPPER_COIN, Price::SILVER_COIN, Price::GOLD_COIN];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function Broken_unit_check_is_detected_on_cast_to_copper()
    {
        $price = new BrokenPriceMeasurement(123, 'non-existing unit');
        $price->getCopperCoins();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function Broken_unit_check_is_detected_on_cast_to_silver()
    {
        $price = new BrokenPriceMeasurement(123, 'non-existing unit');
        $price->getSilverCoins();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function Broken_unit_check_is_detected_on_cast_to_gold()
    {
        $price = new BrokenPriceMeasurement(123, 'non-existing unit');
        $price->getGoldCoins();
    }

}

/** inner */
class BrokenPriceMeasurement extends Price
{
    protected function checkUnit($unit)
    {
        return true;
    }
}
