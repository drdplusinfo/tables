<?php
namespace DrdPlus\Tests\Tables\Armaments\Armors;

use DrdPlus\Tables\Armaments\Armors\AbstractArmorsTable;
use DrdPlus\Tests\Tables\TableTest;

abstract class AbstractArmorsTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $sutClass = $this->getSutClass();
        /** @var AbstractArmorsTable $armorsTable */
        $armorsTable = new $sutClass();
        self::assertSame(
            [[$this->getRowHeaderName(), 'required_strength', 'restriction', 'protection', 'weight']],
            $armorsTable->getHeader()
        );
    }

    /**
     * @return string
     */
    protected function getRowHeaderName()
    {
        $sutClass = $this->getSutClass();
        $baseName = preg_replace('~(?:.+[\\\])?(\w+)~', '$1', $sutClass);

        $rawHeaderName = str_replace('sTable', '', $baseName);

        return implode('_', array_map(
            function ($headerNamePart) {
                return lcfirst($headerNamePart);
            },
            preg_split('~([A-Z][a-z]+)~', $rawHeaderName, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY)
        ));
    }

    /**
     * @return string|AbstractArmorsTable
     */
    protected function getSutClass()
    {
        return preg_replace('~[\\\]Tests([\\\].+)Test$~', '$1', static::class);
    }

    /**
     * @test
     * @dataProvider provideArmorAndValue
     * @param string $armorCode
     * @param string $valueName
     * @param mixed $expectedValue
     */
    public function I_can_get_values_for_every_armor($armorCode, $valueName, $expectedValue)
    {
        $sutClass = $this->getSutClass();
        /** @var AbstractArmorsTable $armorsTable */
        $armorsTable = new $sutClass();
        $value = $armorsTable->getValue([$armorCode], $valueName);
        self::assertSame($expectedValue, $value);
        $getValueNameOf = 'get' . implode(array_map(
                function ($namePart) {
                    return ucfirst($namePart);
                },
                explode('_', $valueName)
            )) . 'Of';
        self::assertSame($value, $armorsTable->$getValueNameOf($armorCode));
    }

    abstract public function provideArmorAndValue();

    /**
     * @test
     * @expectedException \DrdPlus\Tables\Armaments\Armors\Exceptions\UnknownArmorCode
     */
    public function I_can_not_get_value_for_unknown_armor()
    {
        $sutClass = $this->getSutClass();
        /** @var AbstractArmorsTable $armorsTable */
        $armorsTable = new $sutClass();
        $armorsTable->getProtectionOf('skeleton armor of never-life');
    }

}
