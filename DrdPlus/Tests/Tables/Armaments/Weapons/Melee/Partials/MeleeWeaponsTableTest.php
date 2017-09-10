<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

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
        $meleeWeaponsTable = $this->createSut();
        self::assertSame(
            [['weapon', 'required_strength', 'length', 'offensiveness', 'wounds', 'wounds_type', 'cover', 'weight', 'two_handed_only']],
            $meleeWeaponsTable->getHeader()
        );
    }

    protected function createSut(): MeleeWeaponsTable
    {
        $sutClass = self::getSutClass();

        return new $sutClass();
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
        $meleeWeaponsTable = $this->createSut();
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