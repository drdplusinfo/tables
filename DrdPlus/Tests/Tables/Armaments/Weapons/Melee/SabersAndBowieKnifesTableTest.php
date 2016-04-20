<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class SabersAndBowieKnifesTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCodes::MACHETE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCodes::MACHETE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCodes::MACHETE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::MACHETE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 2],
            [WeaponCodes::MACHETE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::MACHETE, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::MACHETE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.0],

            [WeaponCodes::LIGHT_SABER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCodes::LIGHT_SABER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCodes::LIGHT_SABER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::LIGHT_SABER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 1],
            [WeaponCodes::LIGHT_SABER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::LIGHT_SABER, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::LIGHT_SABER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.2],

            [WeaponCodes::BOWIE_KNIFE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCodes::BOWIE_KNIFE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCodes::BOWIE_KNIFE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::BOWIE_KNIFE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 3],
            [WeaponCodes::BOWIE_KNIFE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::BOWIE_KNIFE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::BOWIE_KNIFE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.2],

            [WeaponCodes::SABER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCodes::SABER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCodes::SABER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCodes::SABER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCodes::SABER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::SABER, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::SABER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.5],

            [WeaponCodes::HEAVY_SABER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 9],
            [WeaponCodes::HEAVY_SABER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCodes::HEAVY_SABER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCodes::HEAVY_SABER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 6],
            [WeaponCodes::HEAVY_SABER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::HEAVY_SABER, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::HEAVY_SABER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],
        ];
    }

}