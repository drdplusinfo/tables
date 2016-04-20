<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class SwordsTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [

            [WeaponCodes::SHORT_SWORD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCodes::SHORT_SWORD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCodes::SHORT_SWORD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::SHORT_SWORD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 1],
            [WeaponCodes::SHORT_SWORD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::SHORT_SWORD, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::SHORT_SWORD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.3],

            [WeaponCodes::HANGER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 4],
            [WeaponCodes::HANGER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCodes::HANGER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::HANGER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 3],
            [WeaponCodes::HANGER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::HANGER, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::HANGER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.5],

            [WeaponCodes::GLAIVE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCodes::GLAIVE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCodes::GLAIVE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCodes::GLAIVE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCodes::GLAIVE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::GLAIVE, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::GLAIVE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.8],

            [WeaponCodes::LONG_SWORD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 7],
            [WeaponCodes::LONG_SWORD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCodes::LONG_SWORD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 5],
            [WeaponCodes::LONG_SWORD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 3],
            [WeaponCodes::LONG_SWORD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::LONG_SWORD, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::LONG_SWORD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],
            
            [WeaponCodes::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 8],
            [WeaponCodes::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCodes::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 5],
            [WeaponCodes::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 5],
            [WeaponCodes::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::COVER_HEADER, 5],
            [WeaponCodes::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.2],

            [WeaponCodes::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 10],
            [WeaponCodes::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCodes::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 6],
            [WeaponCodes::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 6],
            [WeaponCodes::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.5],

            [WeaponCodes::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 12],
            [WeaponCodes::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCodes::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 5],
            [WeaponCodes::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 9],
            [WeaponCodes::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 4.0],
        ];
    }

}
