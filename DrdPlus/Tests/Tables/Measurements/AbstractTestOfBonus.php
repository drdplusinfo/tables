<?php
namespace DrdPlus\Tests\Tables\Measurements;

use DrdPlus\Tables\Measurements\BonusInterface;
use DrdPlus\Tables\Measurements\MeasurementWithBonusInterface;
use DrdPlus\Tools\Tests\TestWithMockery;

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
        $tableClass = $this->getTableClass();

        return new $tableClass();
    }

    protected function getTableClass()
    {
        $tableClass = preg_replace('~Bonus$~', 'Table', $this->getBonusClass());

        return $tableClass;
    }

    /**
     * @test
     */
    public function I_can_get_measurement_from_bonus()
    {
        $sut = $this->createSut($bonusValue = 12);
        $this->assertSame($bonusValue, $sut->getValue());
        $getMeasurement = $this->getNameOfMeasurementGetter();
        $measurement = $sut->$getMeasurement();
        /** @var MeasurementWithBonusInterface $measurement */
        $this->assertInstanceOf($this->getMeasurementClass(), $measurement);
        $this->assertInstanceOf($this->getBonusClass(), $measurement->getBonus());
        // the bonus-to-measurement-to-bonus can be lossy transformation
        $this->assertTrue(
            $measurement->getBonus()->getValue() === $bonusValue
            || $measurement->getBonus()->getValue() === $bonusValue - 1
            || $measurement->getBonus()->getValue() === $bonusValue + 1
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
