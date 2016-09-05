<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Ranged\Partials;

use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Partials\WeaponlikeTableTest;

abstract class RangedWeaponsTableTest extends WeaponlikeTableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $sutClass = $this->getSutClass();
        /** @var RangedWeaponsTable $shootingArmamentsTable */
        $shootingArmamentsTable = new $sutClass();
        self::assertSame(
            [[$this->getRowHeaderName(), 'required_strength', 'offensiveness', 'wounds', 'wounds_type', 'range', 'cover', 'weight', 'two_handed']],
            $shootingArmamentsTable->getHeader()
        );
    }

    /**
     * @return string
     */
    abstract protected function getRowHeaderName();

    /**
     * @test
     * @dataProvider provideValueName
     * @param string $valueName
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     * @expectedExceptionMessageRegExp ~skull_crasher~
     */
    public function I_can_not_get_value_of_unknown_melee_weapon($valueName)
    {
        $getValueNameOf = $this->assembleValueGetter($valueName);
        $sutClass = $this->getSutClass();
        /** @var RangedWeaponsTable $shootingArmamentsTable */
        $shootingArmamentsTable = new $sutClass();
        $shootingArmamentsTable->$getValueNameOf('skull_crasher');
    }

    public function provideValueName()
    {
        return [
            [RangedWeaponsTable::REQUIRED_STRENGTH],
            [RangedWeaponsTable::OFFENSIVENESS],
            [RangedWeaponsTable::WOUNDS],
            [RangedWeaponsTable::WOUNDS_TYPE],
            [RangedWeaponsTable::RANGE],
            [RangedWeaponsTable::COVER],
            [RangedWeaponsTable::WEIGHT],
            [RangedWeaponsTable::TWO_HANDED, false],
        ];
    }

}