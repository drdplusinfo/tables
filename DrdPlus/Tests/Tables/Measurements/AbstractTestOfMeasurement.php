<?php
namespace DrdPlus\Tests\Tables\Measurements;

use DrdPlus\Tables\Measurements\Measurement;
use DrdPlus\Tables\Parts\AbstractTable;
use DrdPlus\Tables\Table;
use Granam\Tests\Tools\TestWithMockery;

abstract class AbstractTestOfMeasurement extends TestWithMockery
{

    /**
     * @test
     */
    public function I_can_get_value_and_unit()
    {
        $measurement = $this->createSut($amount = 123);
        self::assertEquals($amount, $measurement->getValue());
        self::assertSame($this->getDefaultUnit(), $measurement->getUnit());
    }

    /**
     * @param int $amount
     *
     * @return Measurement
     */
    protected function createSut($amount)
    {
        $sutClass = self::getSutClass();
        $unit = $this->getDefaultUnit();
        $table = $this->findTable();

        if (!$table) {
            return new $sutClass($amount, $unit);
        }

        return $this->createSutWithTable($sutClass, $amount, $unit, $table);
    }

    protected function createSutWithTable($sutClass, $amount, $unit, Table $table)
    {
        return new $sutClass($amount, $unit, $table);
    }

    /**
     * @return string|Measurement
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
        $class = self::getSutClass();

        return "$class::$constantBaseName";
    }

    protected function getConstantBaseName()
    {
        $classBaseName = $this->parseClassBaseName(self::getSutClass());
        $underscored = ltrim(preg_replace('~([A-Z])~', '_$1', $classBaseName), '_');

        return strtoupper($underscored);
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
        $measurementClass = self::getSutClass();
        $tableClass = "{$measurementClass}Table";

        if (!class_exists($tableClass)) {
            return false;
        }

        return $tableClass;
    }
}
