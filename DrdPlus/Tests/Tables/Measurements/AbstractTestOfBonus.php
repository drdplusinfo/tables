<?php
namespace DrdPlus\Tests\Tables\Measurements;

use DrdPlus\Tables\Measurements\BonusInterface;
use DrdPlus\Tables\Measurements\MeasurementWithBonus;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractTestOfBonus extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_create_bonus()
    {
        $sut = $this->createSut($value = 123);
        self::assertInstanceOf(BonusInterface::class, $sut);
        self::assertSame($value, $sut->getValue());
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
        return preg_replace('~Bonus$~', 'Table', $this->getBonusClass());
    }

    /**
     * @test
     */
    public function I_can_get_measurement_from_bonus()
    {
        $sut = $this->createSut($bonusValue = 12);
        self::assertSame($bonusValue, $sut->getValue());
        $getMeasurement = $this->getNameOfMeasurementGetter();
        $measurement = $sut->$getMeasurement();
        /** @var MeasurementWithBonus $measurement */
        self::assertInstanceOf($this->getMeasurementClass(), $measurement);
        self::assertInstanceOf($this->getBonusClass(), $measurement->getBonus());
        // the bonus-to-measurement-to-bonus can be lossy transformation
        self::assertTrue(
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
