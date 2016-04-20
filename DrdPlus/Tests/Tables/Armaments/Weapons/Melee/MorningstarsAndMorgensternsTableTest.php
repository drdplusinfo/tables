<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class MorningstarsAndMorgensternsTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCodes::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCodes::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCodes::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 3],
            [WeaponCodes::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::LIGHT_MORGENSTERN, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],

            [WeaponCodes::MORGENSTERN, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 7],
            [WeaponCodes::MORGENSTERN, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCodes::MORGENSTERN, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::MORGENSTERN, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 6],
            [WeaponCodes::MORGENSTERN, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::MORGENSTERN, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::MORGENSTERN, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.5],

            [WeaponCodes::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 11],
            [WeaponCodes::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCodes::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 9],
            [WeaponCodes::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::HEAVY_MORGENSTERN, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 3.0],

            [WeaponCodes::FLAIL, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCodes::FLAIL, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::FLAIL, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::FLAIL, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCodes::FLAIL, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::FLAIL, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::FLAIL, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],

            [WeaponCodes::MORNINGSTAR, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCodes::MORNINGSTAR, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::MORNINGSTAR, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::MORNINGSTAR, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 8],
            [WeaponCodes::MORNINGSTAR, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::MORNINGSTAR, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::MORNINGSTAR, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 3.0],

            [WeaponCodes::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 7],
            [WeaponCodes::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 10],
            [WeaponCodes::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::HOBNAILED_FLAIL, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 4.0],

            [WeaponCodes::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 11],
            [WeaponCodes::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 13],
            [WeaponCodes::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CRUSH],
            [WeaponCodes::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::HEAVY_MORNINGSTAR, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 5.0],
        ];
    }

}