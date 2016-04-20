<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class VoulgesAndTridentsTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCodes::PITCHFORK, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 0],
            [WeaponCodes::PITCHFORK, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCodes::PITCHFORK, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::PITCHFORK, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 2],
            [WeaponCodes::PITCHFORK, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::PITCHFORK, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::PITCHFORK, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.5],

            [WeaponCodes::LIGHT_VOULGE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCodes::LIGHT_VOULGE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::LIGHT_VOULGE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCodes::LIGHT_VOULGE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCodes::LIGHT_VOULGE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::LIGHT_VOULGE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::LIGHT_VOULGE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],

            [WeaponCodes::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 5],
            [WeaponCodes::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 6],
            [WeaponCodes::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::LIGHT_TRIDENT, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.5],

            [WeaponCodes::HALBERD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCodes::HALBERD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::HALBERD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::HALBERD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 7],
            [WeaponCodes::HALBERD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::HALBERD, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::HALBERD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 3.5],

            [WeaponCodes::HEAVY_VOULGE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 7],
            [WeaponCodes::HEAVY_VOULGE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::HEAVY_VOULGE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCodes::HEAVY_VOULGE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 9],
            [WeaponCodes::HEAVY_VOULGE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::HEAVY_VOULGE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::HEAVY_VOULGE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 4.0],

            [WeaponCodes::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 9],
            [WeaponCodes::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 10],
            [WeaponCodes::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCodes::HEAVY_TRIDENT, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 4.0],

            [WeaponCodes::HEAVY_HALBERD, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 10],
            [WeaponCodes::HEAVY_HALBERD, AbstractMeleeWeaponsTable::LENGTH_HEADER, 4],
            [WeaponCodes::HEAVY_HALBERD, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCodes::HEAVY_HALBERD, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 12],
            [WeaponCodes::HEAVY_HALBERD, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::CUT],
            [WeaponCodes::HEAVY_HALBERD, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCodes::HEAVY_HALBERD, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 6.0],
        ];
    }

}
