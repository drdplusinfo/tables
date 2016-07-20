<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\MorningstarsAndMorgensternsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class MorningstarsAndMorgensternsTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCode::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCode::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCode::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 3],
            [WeaponCode::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],

            [WeaponCode::MORGENSTERN, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 7],
            [WeaponCode::MORGENSTERN, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCode::MORGENSTERN, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::MORGENSTERN, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 6],
            [WeaponCode::MORGENSTERN, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::MORGENSTERN, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::MORGENSTERN, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.5],

            [WeaponCode::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 11],
            [WeaponCode::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCode::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 9],
            [WeaponCode::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 3.0],

            [WeaponCode::FLAIL, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCode::FLAIL, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::FLAIL, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::FLAIL, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCode::FLAIL, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::FLAIL, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::FLAIL, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],

            [WeaponCode::MORNINGSTAR, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCode::MORNINGSTAR, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::MORNINGSTAR, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::MORNINGSTAR, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 8],
            [WeaponCode::MORNINGSTAR, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::MORNINGSTAR, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::MORNINGSTAR, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 3.0],

            [WeaponCode::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 7],
            [WeaponCode::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 10],
            [WeaponCode::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 4.0],

            [WeaponCode::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 11],
            [WeaponCode::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCode::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 13],
            [WeaponCode::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 5.0],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $morningstarsAndMorgensternsTable = new MorningstarsAndMorgensternsTable();
        foreach (WeaponCode::getMorningstarAndMorgensternCodes() as $morningstarAndMorgensternCode) {
            $row = $morningstarsAndMorgensternsTable->getRow([$morningstarAndMorgensternCode]);
            self::assertNotEmpty($row);
        }
    }

}