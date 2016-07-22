<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Shooting\Partials;

use DrdPlus\Tables\Armaments\Weapons\Shooting\Partials\ShootingWeaponsTable;
use DrdPlus\Tests\Tables\TableTest;

abstract class ShootingWeaponsTableTest extends \PHPUnit_Framework_TestCase implements TableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $sutClass = $this->getSutClass();
        /** @var ShootingWeaponsTable $shootingArmamentsTable */
        $shootingArmamentsTable = new $sutClass();
        self::assertSame(
            [[$this->getRowHeaderValue(), 'required_strength', 'offensiveness', 'wounds', 'wounds_type', 'range', 'weight']],
            $shootingArmamentsTable->getHeader()
        );
    }

    /**
     * @return string
     */
    abstract protected function getRowHeaderValue();

    /**
     * @return string|ShootingWeaponsTable
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
        /** @var ShootingWeaponsTable $shootingArmamentsTable */
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
     * @expectedException \DrdPlus\Tables\Armaments\Weapons\Shooting\Exceptions\UnknownShootingWeaponCode
     * @expectedExceptionMessageRegExp ~skull_crasher~
     */
    public function I_can_not_get_value_of_unknown_melee_weapon($valueName)
    {
        $getValueNameOf = $this->assembleValueGetter($valueName);
        $sutClass = $this->getSutClass();
        /** @var ShootingWeaponsTable $shootingArmamentsTable */
        $shootingArmamentsTable = new $sutClass();
        $shootingArmamentsTable->$getValueNameOf('skull_crasher');
    }

    public function provideValueName()
    {
        return [
            [ShootingWeaponsTable::REQUIRED_STRENGTH],
            [ShootingWeaponsTable::OFFENSIVENESS],
            [ShootingWeaponsTable::WOUNDS],
            [ShootingWeaponsTable::WOUNDS_TYPE],
            [ShootingWeaponsTable::RANGE],
            [ShootingWeaponsTable::WEIGHT],
        ];
    }

}