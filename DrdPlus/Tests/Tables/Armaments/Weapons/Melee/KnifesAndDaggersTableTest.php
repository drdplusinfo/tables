<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class KnifesAndDaggersTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCodes::KNIFE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, -3],
            [WeaponCodes::KNIFE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCodes::KNIFE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::KNIFE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, -2],
            [WeaponCodes::KNIFE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::KNIFE, AbstractMeleeWeaponsTable::COVER_HEADER, 1],
            [WeaponCodes::KNIFE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.2],

            [WeaponCodes::DAGGER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, -1],
            [WeaponCodes::DAGGER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCodes::DAGGER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCodes::DAGGER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 1],
            [WeaponCodes::DAGGER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::DAGGER, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::DAGGER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.2],

            [WeaponCodes::STABBING_DAGGER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, -1],
            [WeaponCodes::STABBING_DAGGER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCodes::STABBING_DAGGER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::STABBING_DAGGER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 0],
            [WeaponCodes::STABBING_DAGGER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::STABBING_DAGGER, AbstractMeleeWeaponsTable::COVER_HEADER, 1],
            [WeaponCodes::STABBING_DAGGER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.2],

            [WeaponCodes::LONG_KNIFE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, -2],
            [WeaponCodes::LONG_KNIFE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCodes::LONG_KNIFE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCodes::LONG_KNIFE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, -1],
            [WeaponCodes::LONG_KNIFE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::LONG_KNIFE, AbstractMeleeWeaponsTable::COVER_HEADER, 1],
            [WeaponCodes::LONG_KNIFE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.2],

            [WeaponCodes::LONG_DAGGER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 1],
            [WeaponCodes::LONG_DAGGER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCodes::LONG_DAGGER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCodes::LONG_DAGGER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 2],
            [WeaponCodes::LONG_DAGGER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::LONG_DAGGER, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCodes::LONG_DAGGER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.3],
        ];
    }

}