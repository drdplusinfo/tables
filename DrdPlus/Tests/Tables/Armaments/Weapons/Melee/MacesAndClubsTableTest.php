<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\WeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\MacesAndClubsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class MacesAndClubsTableTest extends AbstractMeleeWeaponsTableTest
{

    public function provideWeaponAndNameWithValue()
    {
        return [
            [WeaponCode::CUDGEL, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 1],
            [WeaponCode::CUDGEL, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCode::CUDGEL, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 1],
            [WeaponCode::CUDGEL, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 2],
            [WeaponCode::CUDGEL, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::CUDGEL, AbstractMeleeWeaponsTable::COVER_HEADER, 1],
            [WeaponCode::CUDGEL, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 0.4],

            [WeaponCode::CLUB, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 3],
            [WeaponCode::CLUB, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCode::CLUB, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::CLUB, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 3],
            [WeaponCode::CLUB, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::CLUB, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::CLUB, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 1.0],

            [WeaponCode::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 5],
            [WeaponCode::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::LENGTH_HEADER, 1],
            [WeaponCode::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 2],
            [WeaponCode::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 5],
            [WeaponCode::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::HOBNAILED_CLUB, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.0],

            [WeaponCode::LIGHT_MACE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 5],
            [WeaponCode::LIGHT_MACE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCode::LIGHT_MACE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::LIGHT_MACE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 4],
            [WeaponCode::LIGHT_MACE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::LIGHT_MACE, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::LIGHT_MACE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 2.5],

            [WeaponCode::MACE, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 8],
            [WeaponCode::MACE, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCode::MACE, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCode::MACE, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 6],
            [WeaponCode::MACE, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::MACE, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::MACE, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 4.0],

            [WeaponCode::HEAVY_CLUB, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 8],
            [WeaponCode::HEAVY_CLUB, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCode::HEAVY_CLUB, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::HEAVY_CLUB, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 7],
            [WeaponCode::HEAVY_CLUB, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::HEAVY_CLUB, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::HEAVY_CLUB, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 3.5],

            [WeaponCode::WAR_HAMMER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 10],
            [WeaponCode::WAR_HAMMER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCode::WAR_HAMMER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 5],
            [WeaponCode::WAR_HAMMER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 7],
            [WeaponCode::WAR_HAMMER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::WAR_HAMMER, AbstractMeleeWeaponsTable::COVER_HEADER, 3],
            [WeaponCode::WAR_HAMMER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 4.5],

            [WeaponCode::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 11],
            [WeaponCode::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::LENGTH_HEADER, 2],
            [WeaponCode::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 3],
            [WeaponCode::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 10],
            [WeaponCode::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::TWO_HANDED_CLUB, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 5.0],

            [WeaponCode::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::REQUIRED_STRENGTH_HEADER, 13],
            [WeaponCode::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::LENGTH_HEADER, 3],
            [WeaponCode::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::OFFENSIVENESS_HEADER, 4],
            [WeaponCode::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::WOUNDS_HEADER, 11],
            [WeaponCode::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::WOUNDS_TYPE_HEADER, WoundTypeCode::CRUSH],
            [WeaponCode::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::COVER_HEADER, 2],
            [WeaponCode::HEAVY_SLEDGEHAMMER, AbstractMeleeWeaponsTable::WEIGHT_HEADER, 5.0],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $macesAndClubsTable = new MacesAndClubsTable();
        foreach (WeaponCode::getMaceAndClubCodes() as $maceAndClubCode) {
            $row = $macesAndClubsTable->getRow([$maceAndClubCode]);
            self::assertNotEmpty($row);
        }
    }

}