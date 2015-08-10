<?php
namespace DrdPlus\Tests\Tables\Price;

use DrdPlus\Tables\Price\PriceMeasurement;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class PriceMeasurementTest extends AbstractTestOfMeasurement
{

    protected function getDefaultUnit()
    {
        return PriceMeasurement::COPPER_COIN;
    }

    /**
     * @test
     */
    public function I_can_add_equation_of_copper_in_silver_and_gold()
    {
        $price = new PriceMeasurement($value = 123, $unit = PriceMeasurement::COPPER_COIN);
        $this->assertSame((float)$value, $price->getValue());
        $this->assertSame((float)$value, $price->toCopperCoins());
        $this->assertSame($unit, $price->getUnit());
        $price->addInDifferentUnit($silverValue = $value / 10, PriceMeasurement::SILVER_COIN);
        $this->assertSame($silverValue, $price->toSilverCoins());
        $price->addInDifferentUnit($goldValue = $value / 100, PriceMeasurement::GOLD_COIN);
        $this->assertSame($goldValue, $price->toGoldCoins());
    }

    /**
     * @test
     */
    public function I_can_add_equation_of_silver_in_copper_and_gold()
    {
        $price = new PriceMeasurement($value = 123, $unit = PriceMeasurement::SILVER_COIN);
        $this->assertSame((float)$value, $price->getValue());
        $this->assertSame((float)$value, $price->toSilverCoins());
        $this->assertSame($unit, $price->getUnit());
        $price->addInDifferentUnit($silverValue = $value * 10, PriceMeasurement::COPPER_COIN);
        $this->assertSame((float)$silverValue, $price->toCopperCoins());
        $price->addInDifferentUnit($goldValue = $value / 10, PriceMeasurement::GOLD_COIN);
        $this->assertSame($goldValue, $price->toGoldCoins());
    }

    /**
     * @test
     */
    public function I_can_add_equation_of_gold_in_silver_and_copper()
    {
        $price = new PriceMeasurement($value = 123, $unit = PriceMeasurement::GOLD_COIN);
        $this->assertSame((float)$value, $price->getValue());
        $this->assertSame((float)$value, $price->toGoldCoins());
        $this->assertSame($unit, $price->getUnit());
        $price->addInDifferentUnit($silverValue = $value * 10, PriceMeasurement::SILVER_COIN);
        $this->assertSame((float)$silverValue, $price->toSilverCoins());
        $price->addInDifferentUnit($goldValue = $value * 100, PriceMeasurement::COPPER_COIN);
        $this->assertSame((float)$goldValue, $price->toCopperCoins());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Price\Exceptions\IncorrectAmount
     */
    public function I_cannot_add_wrong_silver_value_to_copper()
    {
        $price = new PriceMeasurement($value = 123, $unit = PriceMeasurement::COPPER_COIN);
        $price->addInDifferentUnit($value * 10 + 1, PriceMeasurement::SILVER_COIN);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Price\Exceptions\IncorrectAmount
     */
    public function I_cannot_add_wrong_gold_value_to_copper()
    {
        $price = new PriceMeasurement($value = 123, $unit = PriceMeasurement::COPPER_COIN);
        $price->addInDifferentUnit($value * 100 + 1, PriceMeasurement::GOLD_COIN);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Price\Exceptions\IncorrectAmount
     */
    public function I_cannot_add_wrong_copper_value_to_silver()
    {
        $price = new PriceMeasurement($value = 123, $unit = PriceMeasurement::SILVER_COIN);
        $price->addInDifferentUnit($value * 10 + 1, PriceMeasurement::COPPER_COIN);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Price\Exceptions\IncorrectAmount
     */
    public function I_cannot_add_wrong_gold_value_to_silver()
    {
        $price = new PriceMeasurement($value = 123, $unit = PriceMeasurement::SILVER_COIN);
        $price->addInDifferentUnit($value / 10 + 1, PriceMeasurement::GOLD_COIN);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Price\Exceptions\IncorrectAmount
     */
    public function I_cannot_add_wrong_copper_value_to_gold()
    {
        $price = new PriceMeasurement($value = 123, $unit = PriceMeasurement::GOLD_COIN);
        $price->addInDifferentUnit($value / 100 + 1, PriceMeasurement::COPPER_COIN);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Price\Exceptions\IncorrectAmount
     */
    public function I_cannot_add_wrong_silver_value_to_gold()
    {
        $price = new PriceMeasurement($value = 123, $unit = PriceMeasurement::GOLD_COIN);
        $price->addInDifferentUnit($value / 10 + 1, PriceMeasurement::SILVER_COIN);
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function Broken_unit_check_is_detected_on_cast_to_copper()
    {
        $price = new BrokenPriceMeasurement(123, 'non-existing unit');
        $price->toCopperCoins();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function Broken_unit_check_is_detected_on_cast_to_silver()
    {
        $price = new BrokenPriceMeasurement(123, 'non-existing unit');
        $price->toSilverCoins();
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function Broken_unit_check_is_detected_on_cast_to_gold()
    {
        $price = new BrokenPriceMeasurement(123, 'non-existing unit');
        $price->toGoldCoins();
    }

}

/** inner */
class BrokenPriceMeasurement extends PriceMeasurement
{
    protected function checkUnit($unit)
    {
        return true;
    }
}
