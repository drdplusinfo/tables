<?php
namespace DrdPlus\Tests\Tables;

use DrdPlus\Tables\BonusInterface;
use DrdPlus\Tables\MeasurementWithBonusInterface;

abstract class AbstractTestOfBonus extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_create_bonus()
    {
        $sut = $this->createSut($value = 123);
        $this->assertInstanceOf(BonusInterface::class, $sut);
        $this->assertSame($value, $sut->getValue());
    }

    /**
     * @param $value
     *
     * @return BonusInterface
     */
    protected function createSut($value)
    {
        $bonusClass = $this->getBonusClass();

        return new $bonusClass($value, $this->getTableInstance());
    }

    protected function getBonusClass()
    {
        return preg_replace('~[\\\]Tests(.+)Test$~', '$1', static::class);
    }

    protected function getTableInstance()
    {
        $tableClass = preg_replace('~Bonus$~', 'Table', $this->getBonusClass());

        return new $tableClass();
    }

    /**
     * @test
     */
    public function I_can_get_measurement_from_bonus()
    {
        $sut = $this->createSut($value = 12);
        $this->assertSame($value, $sut->getValue());
        $getMeasurement = $this->getNameOfMeasurementGetter();
        $measurement = $sut->$getMeasurement();
        /** @var MeasurementWithBonusInterface $measurement */
        $this->assertInstanceOf($this->getMeasurementClass(), $measurement);
        $this->assertInstanceOf($this->getBonusClass(), $measurement->getBonus());
        // the bonus-to-measurement-to-bonus can be lossy transformation
        $this->assertTrue(
            $measurement->getBonus()->getValue() === $value
            || $measurement->getBonus()->getValue() === $value - 1
            || $measurement->getBonus()->getValue() === $value + 1
        );
    }

    protected function getNameOfMeasurementGetter()
    {
        $measurementClass = $this->getMeasurementClass();
        preg_match('~\\\(?<basename>\w+)$~', $measurementClass, $matches);
        $measurementBasename = $matches['basename'];

        return "get$measurementBasename";
    }

    protected function getMeasurementClass()
    {
        $bonusClassName = $this->getBonusClass();

        return preg_replace('~Bonus$~', '', $bonusClassName);
    }
}
