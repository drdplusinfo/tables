<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\MeasurementInterface;

abstract class AbstractTestOfMeasurement extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_add_value_in_same_unit()
    {
        $measurement = $this->createSut($amount = 123, $this->getDefaultUnit());
        $this->assertEquals($amount, $measurement->getValue());
        $this->assertSame($this->getDefaultUnit(), $measurement->getUnit());
        $measurement->addInDifferentUnit($amount, $this->getDefaultUnit());
        $this->assertEquals($amount, $measurement->getValue());
        $this->assertSame($this->getDefaultUnit(), $measurement->getUnit());
    }

    /**
     * @param int $amount
     * @param string $unit
     *
     * @return MeasurementInterface
     */
    protected function createSut($amount, $unit)
    {
        $sutClass = $this->getTestedClass();

        return new $sutClass($amount, $unit);
    }

    /**
     * @return string|MeasurementInterface
     */
    protected static function getTestedClass()
    {
        return preg_replace('~Tests\\\(.+)Test$~', '$1', static::class);
    }

    protected function getDefaultUnit()
    {
        return strtolower(preg_replace('~.+\\\(\w+)MeasurementTest$~', '$1', static::class));
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\UnknownUnit
     */
    public function I_cannot_add_in_different_unit()
    {
        $measurement = $this->createSut($amount = 123, $this->getDefaultUnit());
        $measurement->addInDifferentUnit($amount, 'non-existing-unit');
    }

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Exceptions\SameValueExpectedForSameUnit
     */
    public function I_cannot_add_different_value_with_same_unit()
    {
        $measurement = $this->createSut($amount = 123, $this->getDefaultUnit());
        $measurement->addInDifferentUnit($amount + 1, $this->getDefaultUnit());
    }
}
