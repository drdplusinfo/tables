<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCodes;
use DrdPlus\Codes\WoundTypeCodes;
use DrdPlus\Tables\Armaments\Weapons\Melee\KnifesAndDaggersTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class KnifesAndDaggersTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCodes::KNIFE, KnifesAndDaggersTable::REQUIRED_STRENGTH_HEADER, -3],
            [WeaponCodes::KNIFE, KnifesAndDaggersTable::LENGTH_HEADER, 0],
            [WeaponCodes::KNIFE, KnifesAndDaggersTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCodes::KNIFE, KnifesAndDaggersTable::WOUNDS_HEADER, -2],
            [WeaponCodes::KNIFE, KnifesAndDaggersTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::KNIFE, KnifesAndDaggersTable::COVER_HEADER, 1],
            [WeaponCodes::KNIFE, KnifesAndDaggersTable::WEIGHT_HEADER, 0.2],

            [WeaponCodes::DAGGER, KnifesAndDaggersTable::REQUIRED_STRENGTH_HEADER, -1],
            [WeaponCodes::DAGGER, KnifesAndDaggersTable::LENGTH_HEADER, 0],
            [WeaponCodes::DAGGER, KnifesAndDaggersTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCodes::DAGGER, KnifesAndDaggersTable::WOUNDS_HEADER, 1],
            [WeaponCodes::DAGGER, KnifesAndDaggersTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::DAGGER, KnifesAndDaggersTable::COVER_HEADER, 2],
            [WeaponCodes::DAGGER, KnifesAndDaggersTable::WEIGHT_HEADER, 0.2],

            [WeaponCodes::STABBING_DAGGER, KnifesAndDaggersTable::REQUIRED_STRENGTH_HEADER, -1],
            [WeaponCodes::STABBING_DAGGER, KnifesAndDaggersTable::LENGTH_HEADER, 0],
            [WeaponCodes::STABBING_DAGGER, KnifesAndDaggersTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCodes::STABBING_DAGGER, KnifesAndDaggersTable::WOUNDS_HEADER, 0],
            [WeaponCodes::STABBING_DAGGER, KnifesAndDaggersTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::STABBING_DAGGER, KnifesAndDaggersTable::COVER_HEADER, 1],
            [WeaponCodes::STABBING_DAGGER, KnifesAndDaggersTable::WEIGHT_HEADER, 0.2],

            [WeaponCodes::LONG_KNIFE, KnifesAndDaggersTable::REQUIRED_STRENGTH_HEADER, -2],
            [WeaponCodes::LONG_KNIFE, KnifesAndDaggersTable::LENGTH_HEADER, 1],
            [WeaponCodes::LONG_KNIFE, KnifesAndDaggersTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCodes::LONG_KNIFE, KnifesAndDaggersTable::WOUNDS_HEADER, -1],
            [WeaponCodes::LONG_KNIFE, KnifesAndDaggersTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::LONG_KNIFE, KnifesAndDaggersTable::COVER_HEADER, 1],
            [WeaponCodes::LONG_KNIFE, KnifesAndDaggersTable::WEIGHT_HEADER, 0.2],

            [WeaponCodes::LONG_DAGGER, KnifesAndDaggersTable::REQUIRED_STRENGTH_HEADER, 1],
            [WeaponCodes::LONG_DAGGER, KnifesAndDaggersTable::LENGTH_HEADER, 1],
            [WeaponCodes::LONG_DAGGER, KnifesAndDaggersTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCodes::LONG_DAGGER, KnifesAndDaggersTable::WOUNDS_HEADER, 2],
            [WeaponCodes::LONG_DAGGER, KnifesAndDaggersTable::WOUNDS_TYPE_HEADER, WoundTypeCodes::STAB],
            [WeaponCodes::LONG_DAGGER, KnifesAndDaggersTable::COVER_HEADER, 2],
            [WeaponCodes::LONG_DAGGER, KnifesAndDaggersTable::WEIGHT_HEADER, 0.3],
        ];
    }

}