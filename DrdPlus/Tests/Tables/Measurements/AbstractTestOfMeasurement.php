<?php
namespace DrdPlus\Tests\Tables\Measurements;

use DrdPlus\Tables\Measurements\MeasurementInterface;
use DrdPlus\Tables\Measurements\Parts\AbstractTable;

abstract class AbstractTestOfMeasurement extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_get_value_and_unit()
    {
        $measurement = $this->createSut($amount = 123);
        $this->assertEquals($amount, $measurement->getValue());
        $this->assertSame($this->getDefaultUnit(), $measurement->getUnit());
    }

    /**
     * @param int $amount
     *
     * @return MeasurementInterface
     */
    protected function createSut($amount)
    {
        $sutClass = $this->getSutClass();
        $unit = $this->getDefaultUnit();
        $table = $this->findTable();

        if (!$table) {
            return new $sutClass($amount, $unit);
        }

        return new $sutClass($amount, $unit, $table);
    }

    /**
     * @return string|MeasurementInterface
     */
    protected static function getSutClass()
    {
        return preg_replace('~Tests\\\(.+)Test$~', '$1', static::class);
    }

    protected function getDefaultUnit()
    {
        return constant($this->getConstantAbsoluteName());
    }

    protected function getConstantAbsoluteName()
    {
        $constantBaseName = $this->getConstantBaseName();
        $class = $this->getSutClass();

        return "$class::$constantBaseName";
    }

    protected function getConstantBaseName()
    {
        $classBaseName = $this->parseClassBaseName($this->getSutClass());
        $underscored = ltrim(preg_replace('~([A-Z])~', '_$1', $classBaseName), '_');
        $constantBaseName = strtoupper($underscored);

        return $constantBaseName;
    }

    /**
     * @param string $className
     *
     * @return string
     */
    protected function parseClassBaseName($className)
    {
        return preg_replace('~.+\\\(\w+)$~', '$1', $className);
    }

    /**
     * @return string[]
     */
    protected function getAllUnits()
    {
        return [$this->getDefaultUnit()];
    }

    /**
     * @return \Mockery\MockInterface|AbstractTable|null
     */
    protected function findTable()
    {
        $tableClass = $this->getTableClass();
        if (!$tableClass) {
            return null;
        }

        return $this->mockery($tableClass);
    }

    /**
     * @return string
     */
    protected function getTableClass()
    {
        $measurementClass = $this->getSutClass();
        $tableClass = "{$measurementClass}Table";

        if (!class_exists($tableClass)) {
            return false;
        }

        return $tableClass;
    }
}
