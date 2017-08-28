<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials;

use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Partials\WeaponlikeTableTest;

abstract class MeleeWeaponsTableTest extends WeaponlikeTableTest
{
    /**
     * @test
     */
    public function I_can_get_header()
    {
        $sutClass = self::getSutClass();
        /** @var MeleeWeaponsTable $meleeWeaponsTable */
        $meleeWeaponsTable = new $sutClass();
        self::assertSame(
            [['weapon', 'required_strength', 'length', 'offensiveness', 'wounds', 'wounds_type', 'cover', 'weight', 'two_handed_only']],
            $meleeWeaponsTable->getHeader()
        );
    }

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
        $sutClass = self::getSutClass();
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