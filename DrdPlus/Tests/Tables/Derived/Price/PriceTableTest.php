<?php
namespace DrdPlus\Tests\Tables\Derived\Price;

use DrdPlus\Tables\Base\Amount\AmountTable;
use DrdPlus\Tables\Derived\Price\PriceMeasurement;
use DrdPlus\Tables\Derived\Price\PriceTable;
use DrdPlus\Tests\Tables\TestWithMockery;

class PriceTableTest extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_convert_price_to_amount_bonus()
    {
        $price = new PriceTable($amountTable = $this->createAmountTable());
        $amountTable->shouldReceive('amountToBonus')
            ->atLeast()->once()
            ->andReturn($bonus = 123);
        $priceMeasurement = $this->createPriceMeasurement();
        $priceMeasurement->shouldReceive('getValue')
            ->atLeast()->once()
            ->andReturn($value = 456);
        $this->assertSame($bonus, $price->toBonus($priceMeasurement));
    }

    /**
     * @return \Mockery\MockInterface|AmountTable
     */
    private function createAmountTable()
    {
        return $this->mockery(AmountTable::class);
    }

    /**
     * @return \Mockery\MockInterface|PriceMeasurement
     */
    private function createPriceMeasurement()
    {
        return $this->mockery(PriceMeasurement::class);
    }

    /**
     * @test
     */
    public function I_can_convert_bonus_to_price()
    {
        $price = new PriceTable($amountTable = $this->createAmountTable());
        $amountTable->shouldReceive('toAmount')
            ->atLeast()->once()
            ->andReturn($amount = 12345);
        $measurement = $price->toMeasurement(45678, $usedUnit = PriceMeasurement::COPPER_COIN);
        $this->assertSame((float)$amount, $measurement->getValue());
        $this->assertSame($usedUnit, $measurement->getUnit());
    }

    /**
     * @test
     */
    public function I_can_convert_price_to_any_currency()
    {
        $price = new PriceTable($amountTable = $this->createAmountTable());
        $amountTable->shouldReceive('toAmount')
            ->atLeast()->once()
            ->andReturn($amount = 12345);

        $inCopper = $price->toMeasurement(45678, $usedUnit = PriceMeasurement::COPPER_COIN);
        $this->assertSame((float)$amount, $inCopper->getValue());
        $this->assertSame((float)$amount, $inCopper->toCopperCoins());
        $this->assertSame((float)$amount / 10, $inCopper->toSilverCoins());
        $this->assertSame((float)$amount / 100, $inCopper->toGoldCoins());

        $inSilver = $price->toMeasurement(45678, $usedUnit = PriceMeasurement::SILVER_COIN);
        $this->assertSame((float)$amount, $inSilver->getValue());
        $this->assertSame((float)$amount, $inSilver->toSilverCoins());
        $this->assertSame((float)$amount * 10, $inSilver->toCopperCoins());
        $this->assertSame((float)$amount / 10, $inSilver->toGoldCoins());

        $inGold = $price->toMeasurement(45678, $usedUnit = PriceMeasurement::GOLD_COIN);
        $this->assertSame((float)$amount, $inGold->getValue());
        $this->assertSame((float)$amount, $inGold->toGoldCoins());
        $this->assertSame((float)$amount * 100, $inGold->toCopperCoins());
        $this->assertSame((float)$amount * 10, $inGold->toSilverCoins());
    }
}
