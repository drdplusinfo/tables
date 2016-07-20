<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\KnifesAndDaggersTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class KnifesAndDaggersTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCode::KNIFE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, -3],
            [WeaponCode::KNIFE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCode::KNIFE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 0],
            [WeaponCode::KNIFE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, -2],
            [WeaponCode::KNIFE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::KNIFE, AbstractMeleeWeaponsTable::COVER_HEADER, 1],
            [WeaponCode::KNIFE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.2],

            [WeaponCode::DAGGER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, -1],
            [WeaponCode::DAGGER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCode::DAGGER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCode::DAGGER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 1],
            [WeaponCode::DAGGER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::DAGGER, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::DAGGER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.2],

            [WeaponCode::STABBING_DAGGER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, -1],
            [WeaponCode::STABBING_DAGGER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 0],
            [WeaponCode::STABBING_DAGGER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::STABBING_DAGGER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 0],
            [WeaponCode::STABBING_DAGGER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::STABBING_DAGGER, AbstractMeleeWeaponsTable::COVER_HEADER, 1],
            [WeaponCode::STABBING_DAGGER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.2],

            [WeaponCode::LONG_KNIFE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, -2],
            [WeaponCode::LONG_KNIFE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCode::LONG_KNIFE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCode::LONG_KNIFE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, -1],
            [WeaponCode::LONG_KNIFE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::LONG_KNIFE, AbstractMeleeWeaponsTable::COVER_HEADER, 1],
            [WeaponCode::LONG_KNIFE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.2],

            [WeaponCode::LONG_DAGGER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 1],
            [WeaponCode::LONG_DAGGER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCode::LONG_DAGGER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCode::LONG_DAGGER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 2],
            [WeaponCode::LONG_DAGGER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::STAB],
            [WeaponCode::LONG_DAGGER, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::LONG_DAGGER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.3],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $knifesAndDaggersTable = new KnifesAndDaggersTable();
        foreach (WeaponCode::getKnifeAndDaggerCodes() as $knifeAndDaggerCode) {
            $row = $knifesAndDaggersTable->getRow([$knifeAndDaggerCode]);
            self::assertNotEmpty($row);
        }
    }

}