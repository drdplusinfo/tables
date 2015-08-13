<?php
namespace DrdPlus\Tests\Tables\Base\Amount;

use DrdPlus\Tables\Base\Amount\AmountMeasurement;
use DrdPlus\Tests\Tables\AbstractTestOfMeasurement;

class AmountMeasurementTest extends AbstractTestOfMeasurement
{

    /**
     * @test
     */
    public function I_can_add_value_in_same_unit()
    {
        $measurement = new AmountMeasurement($amount = 123);
        $measurement->addInDifferentUnit($amount, AmountMeasurement::AMOUNT);
        $this->assertSame((float)$amount, $measurement->getValue());
        $this->assertSame(AmountMeasurement::AMOUNT, $measurement->getUnit());
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function I_cannot_add_in_different_unit()
    {
        $measurement = new AmountMeasurement($amount = 123);
        $measurement->addInDifferentUnit($amount, 'non-existing-unit');
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\SameValueExpectedForSameUnit
     */
    public function I_cannot_add_different_value_with_same_unit()
    {
        $measurement = new AmountMeasurement($amount = 123);
        $measurement->addInDifferentUnit($amount + 1, AmountMeasurement::AMOUNT);
    }
}
