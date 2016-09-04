<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tests\Tables\TableTestInterface;

abstract class MeleeWeaponsTableTest extends \PHPUnit_Framework_TestCase implements TableTestInterface
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $sutClass = $this->getSutClass();
        /** @var MeleeWeaponsTable $meleeWeaponsTable */
        $meleeWeaponsTable = new $sutClass();
        self::assertSame(
            [['weapon', 'required_strength', 'length', 'offensiveness', 'wounds', 'wounds_type', 'cover', 'weight', 'two_handed']],
            $meleeWeaponsTable->getHeader()
        );
    }

    /**
     * @test
     */
    public function I_can_get_all_values()
    {
        $sutClass = $this->getSutClass();
        /** @var MeleeWeaponsTable $meleeWeaponsTable */
        $meleeWeaponsTable = new $sutClass();
        self::assertSame(
            $this->assembleIndexedValues($this->provideWeaponAndNameWithValue()),
            $meleeWeaponsTable->getIndexedValues()
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
     * @return string|MeleeWeaponsTable
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
        /** @var MeleeWeaponsTable $meleeWeaponsTable */
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
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownMeleeWeapon
     * @expectedExceptionMessageRegExp ~skull_crasher~
     */
    public function I_can_not_get_value_of_unknown_melee_weapon($valueName)
    {
        $getValueNameOf = $this->assembleValueGetter($valueName);
        $sutClass = $this->getSutClass();
        /** @var MeleeWeaponsTable $meleeWeaponsTable */
        $meleeWeaponsTable = new $sutClass();
        $meleeWeaponsTable->$getValueNameOf('skull_crasher');
    }

    public function provideValueName()
    {
        return [
            [MeleeWeaponsTable::REQUIRED_STRENGTH],
            [MeleeWeaponsTable::LENGTH],
            [MeleeWeaponsTable::OFFENSIVENESS],
            [MeleeWeaponsTable::WOUNDS],
            [MeleeWeaponsTable::WOUNDS_TYPE],
            [MeleeWeaponsTable::COVER],
            [MeleeWeaponsTable::WEIGHT],
        ];
    }

    /**
     * @test
     */
    abstract public function I_can_get_every_weapon_by_weapon_codes_library();

}