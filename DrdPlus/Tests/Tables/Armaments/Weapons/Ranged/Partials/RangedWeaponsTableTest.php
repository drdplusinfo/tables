<?php
declare(strict_types=1); // on PHP 7+ are standard PHP methods strict to types of given parameters

namespace DrdPlus\Tests\Tables\Armaments\Weapons\Ranged\Partials;

use DrdPlus\Tables\Armaments\Weapons\Ranged\Partials\RangedWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Partials\WeaponlikeTableTest;

abstract class RangedWeaponsTableTest extends WeaponlikeTableTest
{

    /**
     * @return string
     */
    abstract protected function getRowHeaderName(): string;

    /**
     * @test
     * @dataProvider provideValueName
     * @param string $valueName
     * @expectedException \DrdPlus\Tables\Armaments\Exceptions\UnknownRangedWeapon
     * @expectedExceptionMessageRegExp ~skull_crasher~
     */
    public function I_can_not_get_value_of_unknown_melee_weapon(string $valueName)
    {
        $getValueNameOf = $this->assembleValueGetter($valueName);
        $sutClass = self::getSutClass();
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
            [RangedWeaponsTable::TWO_HANDED_ONLY],
        ];
    }

}