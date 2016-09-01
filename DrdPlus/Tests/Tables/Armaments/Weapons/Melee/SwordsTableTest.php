<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\SwordsTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\AbstractMeleeWeaponsTableTest;

class SwordsTableTest extends AbstractMeleeWeaponsTableTest
{
    public function provideWeaponAndNameWithValue()
    {
        return [

            [MeleeWeaponCode::SHORT_SWORD, MeleeWeaponsTable::REQUIRED_STRENGTH, 2],
            [MeleeWeaponCode::SHORT_SWORD, MeleeWeaponsTable::LENGTH, 1],
            [MeleeWeaponCode::SHORT_SWORD, MeleeWeaponsTable::OFFENSIVENESS, 3],
            [MeleeWeaponCode::SHORT_SWORD, MeleeWeaponsTable::WOUNDS, 1],
            [MeleeWeaponCode::SHORT_SWORD, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [MeleeWeaponCode::SHORT_SWORD, MeleeWeaponsTable::COVER, 3],
            [MeleeWeaponCode::SHORT_SWORD, MeleeWeaponsTable::WEIGHT, 1.3],

            [MeleeWeaponCode::HANGER, MeleeWeaponsTable::REQUIRED_STRENGTH, 4],
            [MeleeWeaponCode::HANGER, MeleeWeaponsTable::LENGTH, 1],
            [MeleeWeaponCode::HANGER, MeleeWeaponsTable::OFFENSIVENESS, 3],
            [MeleeWeaponCode::HANGER, MeleeWeaponsTable::WOUNDS, 3],
            [MeleeWeaponCode::HANGER, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [MeleeWeaponCode::HANGER, MeleeWeaponsTable::COVER, 4],
            [MeleeWeaponCode::HANGER, MeleeWeaponsTable::WEIGHT, 1.5],

            [MeleeWeaponCode::GLAIVE, MeleeWeaponsTable::REQUIRED_STRENGTH, 6],
            [MeleeWeaponCode::GLAIVE, MeleeWeaponsTable::LENGTH, 2],
            [MeleeWeaponCode::GLAIVE, MeleeWeaponsTable::OFFENSIVENESS, 4],
            [MeleeWeaponCode::GLAIVE, MeleeWeaponsTable::WOUNDS, 4],
            [MeleeWeaponCode::GLAIVE, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [MeleeWeaponCode::GLAIVE, MeleeWeaponsTable::COVER, 4],
            [MeleeWeaponCode::GLAIVE, MeleeWeaponsTable::WEIGHT, 1.8],

            [MeleeWeaponCode::LONG_SWORD, MeleeWeaponsTable::REQUIRED_STRENGTH, 7],
            [MeleeWeaponCode::LONG_SWORD, MeleeWeaponsTable::LENGTH, 3],
            [MeleeWeaponCode::LONG_SWORD, MeleeWeaponsTable::OFFENSIVENESS, 5],
            [MeleeWeaponCode::LONG_SWORD, MeleeWeaponsTable::WOUNDS, 3],
            [MeleeWeaponCode::LONG_SWORD, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [MeleeWeaponCode::LONG_SWORD, MeleeWeaponsTable::COVER, 4],
            [MeleeWeaponCode::LONG_SWORD, MeleeWeaponsTable::WEIGHT, 2.0],
            
            [MeleeWeaponCode::ONE_AND_HALF_HANDED_SWORD, MeleeWeaponsTable::REQUIRED_STRENGTH, 8],
            [MeleeWeaponCode::ONE_AND_HALF_HANDED_SWORD, MeleeWeaponsTable::LENGTH, 2],
            [MeleeWeaponCode::ONE_AND_HALF_HANDED_SWORD, MeleeWeaponsTable::OFFENSIVENESS, 5],
            [MeleeWeaponCode::ONE_AND_HALF_HANDED_SWORD, MeleeWeaponsTable::WOUNDS, 5],
            [MeleeWeaponCode::ONE_AND_HALF_HANDED_SWORD, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [MeleeWeaponCode::ONE_AND_HALF_HANDED_SWORD, MeleeWeaponsTable::COVER, 5],
            [MeleeWeaponCode::ONE_AND_HALF_HANDED_SWORD, MeleeWeaponsTable::WEIGHT, 2.2],

            [MeleeWeaponCode::BARBARIAN_SWORD, MeleeWeaponsTable::REQUIRED_STRENGTH, 10],
            [MeleeWeaponCode::BARBARIAN_SWORD, MeleeWeaponsTable::LENGTH, 2],
            [MeleeWeaponCode::BARBARIAN_SWORD, MeleeWeaponsTable::OFFENSIVENESS, 6],
            [MeleeWeaponCode::BARBARIAN_SWORD, MeleeWeaponsTable::WOUNDS, 6],
            [MeleeWeaponCode::BARBARIAN_SWORD, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [MeleeWeaponCode::BARBARIAN_SWORD, MeleeWeaponsTable::COVER, 4],
            [MeleeWeaponCode::BARBARIAN_SWORD, MeleeWeaponsTable::WEIGHT, 2.5],

            [MeleeWeaponCode::TWO_HANDED_SWORD, MeleeWeaponsTable::REQUIRED_STRENGTH, 12],
            [MeleeWeaponCode::TWO_HANDED_SWORD, MeleeWeaponsTable::LENGTH, 3],
            [MeleeWeaponCode::TWO_HANDED_SWORD, MeleeWeaponsTable::OFFENSIVENESS, 5],
            [MeleeWeaponCode::TWO_HANDED_SWORD, MeleeWeaponsTable::WOUNDS, 9],
            [MeleeWeaponCode::TWO_HANDED_SWORD, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CUT],
            [MeleeWeaponCode::TWO_HANDED_SWORD, MeleeWeaponsTable::COVER, 4],
            [MeleeWeaponCode::TWO_HANDED_SWORD, MeleeWeaponsTable::WEIGHT, 4.0],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $swordsTable = new SwordsTable();
        foreach (MeleeWeaponCode::getSwordCodes() as $swordCode) {
            $row = $swordsTable->getRow([$swordCode]);
            self::assertNotEmpty($row);
        }
    }

}
