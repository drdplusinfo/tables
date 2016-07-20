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


    /**
     * @test
     * @dataProvider provideValueName
     * @param string $valueName
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Melee\Exceptions\UnknownMeleeWeaponCode
     * @expectedExceptionMessageRegExp ~skull_crasher~
     */
    public function I_can_not_get_value_of_unknown_melee_weapon($valueName)
    {
        $getValueNameOf = $this->assembleValueGetter($valueName);
        $sutClass = $this->getSutClass();
        /** @var AbstractMeleeWeaponsTable $meleeWeaponsTable */
        $meleeWeaponsTable = new $sutClass();
        $meleeWeaponsTable->$getValueNameOf('skull_crasher');
    }

    public function provideValueName()
    {
        return [
            [AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER],
            [AbstractMeleeWeaponsTable::LENGTH_HEADER],
            [AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER],
            [AbstractMeleeWeaponsTable::WOUNDS_HEADER],
            [AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER],
            [AbstractMeleeWeaponsTable::COVER_HEADER],
            [AbstractMeleeWeaponsTable::WEIGHT_HEADER],
        ];
    }

    /**
     * @test
     */
    abstract public function I_can_get_every_weapon_by_weapon_codes_library();

}