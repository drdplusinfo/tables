<?php
namespace DrdPlus\Tests\Tables\Armaments\Partials;

use DrdPlus\Tables\Armaments\Partials\WeaponlikeTable;
use DrdPlus\Tests\Tables\TableTestInterface;

abstract class WeaponlikeTableTest extends \PHPUnit_Framework_TestCase implements TableTestInterface
{

    /**
     * @test
     */
    public function I_can_get_all_values()
    {
        $sutClass = $this->getSutClass();
        /** @var WeaponlikeTable $weaponlikeTable */
        $weaponlikeTable = new $sutClass();
        self::assertSame(
            $this->assembleIndexedValues($this->provideArmamentAndNameWithValue()),
            $weaponlikeTable->getIndexedValues()
        );
    }

    /**
     * @return string|WeaponlikeTable
     */
    protected function getSutClass()
    {
        return preg_replace('~[\\\]Tests([\\\].+)Test$~', '$1', get_called_class());
    }

    private function assembleIndexedValues(array $values)
    {
        $indexedValues = [];
        foreach ($values as $row) {
            list($weapon, $parameterName, $parameterValue) = $row;
            if (!array_key_exists($weapon, $indexedValues)) {
                $indexedValues[$weapon] = [];
            }
            $indexedValues[$weapon][$parameterName] = $parameterValue;
        }

        return $indexedValues;
    }

    /**
     * @return array|mixed[][]
     */
    abstract public function provideArmamentAndNameWithValue();

    /**
     * @test
     * @dataProvider provideArmamentAndNameWithValue
     * @param string $shootingArmamentCode
     * @param string $valueName
     * @param mixed $expectedValue
     */
    public function I_can_get_values_for_every_armament($shootingArmamentCode, $valueName, $expectedValue)
    {
        $sutClass = $this->getSutClass();
        /** @var WeaponlikeTable $shootingArmamentsTable */
        $shootingArmamentsTable = new $sutClass();

        $value = $shootingArmamentsTable->getValue([$shootingArmamentCode], $valueName);
        self::assertSame($expectedValue, $value);

        $getValueOf = $this->assembleValueGetter($valueName);
        self::assertSame($value, $shootingArmamentsTable->$getValueOf($shootingArmamentCode));
    }

    protected function assembleValueGetter($valueName)
    {
        return 'get' . implode(
            array_map(
                function ($namePart) {
                    return ucfirst($namePart);
                },
                explode('_', $valueName)
            )
        ) . 'Of';
    }
}