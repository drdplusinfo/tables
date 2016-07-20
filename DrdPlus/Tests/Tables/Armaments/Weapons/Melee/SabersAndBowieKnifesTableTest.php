<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\SabersAndBowieKnifesTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class SabersAndBowieKnifesTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCode::MACHETE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 2],
            [WeaponCode::MACHETE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCode::MACHETE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::MACHETE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 2],
            [WeaponCode::MACHETE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::MACHETE, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::MACHETE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.0],

            [WeaponCode::LIGHT_SABER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCode::LIGHT_SABER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCode::LIGHT_SABER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::LIGHT_SABER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 1],
            [WeaponCode::LIGHT_SABER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::LIGHT_SABER, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::LIGHT_SABER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.2],

            [WeaponCode::BOWIE_KNIFE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCode::BOWIE_KNIFE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCode::BOWIE_KNIFE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::BOWIE_KNIFE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 3],
            [WeaponCode::BOWIE_KNIFE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::BOWIE_KNIFE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::BOWIE_KNIFE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.2],

            [WeaponCode::SABER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 6],
            [WeaponCode::SABER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCode::SABER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCode::SABER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCode::SABER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::SABER, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::SABER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.5],

            [WeaponCode::HEAVY_SABER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 9],
            [WeaponCode::HEAVY_SABER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCode::HEAVY_SABER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCode::HEAVY_SABER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 6],
            [WeaponCode::HEAVY_SABER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CUT],
            [WeaponCode::HEAVY_SABER, AbstractMeleeWeaponsTable::COVER_HEADER, 4],
            [WeaponCode::HEAVY_SABER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $sabersAndBowieKnifesTable = new SabersAndBowieKnifesTable();
        foreach (WeaponCode::getSaberAndBowieKnifeCodes() as $saberAndBowieKnifeCode) {
            $row = $sabersAndBowieKnifesTable->getRow([$saberAndBowieKnifeCode]);
            self::assertNotEmpty($row);
        }
    }

}