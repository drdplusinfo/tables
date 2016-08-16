<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Range\Partials;

use DrdPlus\Tables\Armaments\Weapons\Range\Partials\RangeWeaponsTable;
use DrdPlus\Tests\Tables\TableTestInterface;

abstract class RangeWeaponsTableTest extends \PHPUnit_Framework_TestCase implements TableTestInterface
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $sutClass = $this->getSutClass();
        /** @var RangeWeaponsTable $shootingArmamentsTable */
        $shootingArmamentsTable = new $sutClass();
        self::assertSame(
            [[$this->getRowHeaderName(), 'required_strength', 'offensiveness', 'wounds', 'wounds_type', 'range', 'weight']],
            $shootingArmamentsTable->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_all_values()
    {
        $sutClass = $this->getSutClass();
        /** @var RangeWeaponsTable $armorsTable */
        $armorsTable = new $sutClass();
        self::assertSame(
            $this->assembleIndexedValues($this->provideArmamentAndNameWithValue()),
            $armorsTable->getIndexedValues()
        );
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
     * @return string
     */
    abstract protected function getRowHeaderName();

    /**
     * @return string|RangeWeaponsTable
     */
    protected function getSutClass()
    {
        return preg_replace('~[\\\]Tests([\\\].+)Test$~', '$1', get_called_class());
    }

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
        /** @var RangeWeaponsTable $shootingArmamentsTable */
        $shootingArmamentsTable = new $sutClass();

        $value = $shootingArmamentsTable->getValue([$shootingArmamentCode], $valueName);
        self::assertSame($expectedValue, $value);

        $getValueOf = $this->assembleValueGetter($valueName);
        self::assertSame($value, $shootingArmamentsTable->$getValueOf($shootingArmamentCode));
    }

    private function assembleValueGetter($valueName)
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

    /**
     * @return array|mixed[][]
     */
    abstract public function provideArmamentAndNameWithValue();

    /**
     * @test
     * @dataProvider provideValueName
     * @param string $valueName
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Range\Exceptions\UnknownRangeWeaponCode
     * @expectedExceptionMessageRegExp ~skull_crasher~
     */
    public function I_can_not_get_value_of_unknown_melee_weapon($valueName)
    {
        $getValueNameOf = $this->assembleValueGetter($valueName);
        $sutClass = $this->getSutClass();
        /** @var RangeWeaponsTable $shootingArmamentsTable */
        $shootingArmamentsTable = new $sutClass();
        $shootingArmamentsTable->$getValueNameOf('skull_crasher');
    }

    public function provideValueName()
    {
        return [
            [RangeWeaponsTable::REQUIRED_STRENGTH],
            [RangeWeaponsTable::OFFENSIVENESS],
            [RangeWeaponsTable::WOUNDS],
            [RangeWeaponsTable::WOUNDS_TYPE],
            [RangeWeaponsTable::RANGE],
            [RangeWeaponsTable::WEIGHT],
        ];
    }

}