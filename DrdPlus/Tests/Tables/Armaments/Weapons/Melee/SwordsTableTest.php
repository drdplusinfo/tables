<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class SwordsTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [

            [WeaponCode::SHORT_SWORD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCode::SHORT_SWORD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCode::SHORT_SWORD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::SHORT_SWORD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 1],
            [WeaponCode::SHORT_SWORD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::SHORT_SWORD, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::SHORT_SWORD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.3],

            [WeaponCode::HANGER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 4],
            [WeaponCode::HANGER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCode::HANGER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::HANGER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 3],
            [WeaponCode::HANGER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::HANGER, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::HANGER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.5],

            [WeaponCode::GLAIVE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCode::GLAIVE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCode::GLAIVE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCode::GLAIVE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCode::GLAIVE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::GLAIVE, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::GLAIVE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.8],

            [WeaponCode::LONG_SWORD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 7],
            [WeaponCode::LONG_SWORD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCode::LONG_SWORD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 5],
            [WeaponCode::LONG_SWORD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 3],
            [WeaponCode::LONG_SWORD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::LONG_SWORD, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::LONG_SWORD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],
            
            [WeaponCode::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 8],
            [WeaponCode::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCode::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 5],
            [WeaponCode::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 5],
            [WeaponCode::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::COVER_HEADER, 5],
            [WeaponCode::ONE_AND_HALF_HANDED_SWORD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.2],

            [WeaponCode::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 10],
            [WeaponCode::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCode::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 6],
            [WeaponCode::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 6],
            [WeaponCode::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::BARBARIAN_SWORD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.5],

            [WeaponCode::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 12],
            [WeaponCode::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCode::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 5],
            [WeaponCode::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 9],
            [WeaponCode::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::TWO_HANDED_SWORD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 4.0],
        ];
    }

}
