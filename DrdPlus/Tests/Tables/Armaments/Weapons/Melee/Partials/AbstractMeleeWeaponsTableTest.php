<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\TableTest;

abstract class AbstractMeleeWeaponsTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $sutClass = $this->getSutClass();
        /** @var AbstractMeleeWeaponsTable $meleeWeaponsTable */
        $meleeWeaponsTable = new $sutClass();
        self::assertSame(
            [['weapon', 'required_strength', 'length', 'offensiveness', 'wounds', 'wounds_type', 'cover', 'weight']],
            $meleeWeaponsTable->getHeader()
        );
    }

    /**
     * @return string|AbstractMeleeWeaponsTable
     */
    protected function getSutClass()
    {
        return preg_replace('~[\\\]Tests([\\\].+)Test$~', '$1', get_called_class());
    }

    /**
     * @test
     * @dataProvider provideWeaponAndNameWithValue
     * @param string $meleeWeaponCode
     * @param string $valueName
     * @param mixed $expectedValue
     */
    public function I_can_get_values_for_every_weapon($meleeWeaponCode, $valueName, $expectedValue)
    {
        $sutClass = $this->getSutClass();
        /** @var AbstractMeleeWeaponsTable $meleeWeaponsTable */
        $meleeWeaponsTable = new $sutClass();

        $value = $meleeWeaponsTable->getValue([$meleeWeaponCode], $valueName);
        self::assertSame($expectedValue, $value);

        $getValueOf = $this->assembleValueGetter($valueName);
        self::assertSame($value, $meleeWeaponsTable->$getValueOf($meleeWeaponCode));
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
    abstract public function provideWeaponAndNameWithValue();

}