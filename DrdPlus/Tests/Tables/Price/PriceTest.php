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
     */
    public function I_can_convert_money_per_base()
    {
        $coppers = new Price($value = 123, Price::COPPER_COIN);
        $this->assertSame((float)$value, $coppers->getCopperCoins());
        $this->assertSame($value / 10, $coppers->getSilverCoins());
        $this->assertSame($value / 100, $coppers->getGoldCoins());

        $silvers = new Price($value = 123, Price::SILVER_COIN);
        $this->assertSame($value * 10.0, $silvers->getCopperCoins());
        $this->assertSame((float)$value, $silvers->getSilverCoins());
        $this->assertSame($value / 10, $silvers->getGoldCoins());

        $golds = new Price($value = 123, Price::GOLD_COIN);
        $this->assertSame($value * 100.0, $golds->getCopperCoins());
        $this->assertSame($value * 10.0, $golds->getSilverCoins());
        $this->assertSame((float)$value, $golds->getGoldCoins());
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
