<?php
namespace DrdPlus\Tests\Tables\Armaments\Weapons\Melee;

use DrdPlus\Codes\Armaments\MeleeWeaponCode;
use DrdPlus\Codes\WoundTypeCode;
use DrdPlus\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTable;
use DrdPlus\Tables\Armaments\Weapons\Melee\UnarmedTable;
use DrdPlus\Tests\Tables\Armaments\Weapons\Melee\Partials\MeleeWeaponsTableTest;

class UnarmedTableTest extends MeleeWeaponsTableTest
{
    public function provideArmamentAndNameWithValue()
    {
        return [
            [MeleeWeaponCode::HAND, MeleeWeaponsTable::REQUIRED_STRENGTH, -5],
            [MeleeWeaponCode::HAND, MeleeWeaponsTable::LENGTH, 0],
            [MeleeWeaponCode::HAND, MeleeWeaponsTable::OFFENSIVENESS, 0],
            [MeleeWeaponCode::HAND, MeleeWeaponsTable::WOUNDS, -2],
            [MeleeWeaponCode::HAND, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::HAND, MeleeWeaponsTable::COVER, 0],
            [MeleeWeaponCode::HAND, MeleeWeaponsTable::WEIGHT, 0.0],
            [MeleeWeaponCode::HAND, MeleeWeaponsTable::TWO_HANDED, false],

            [MeleeWeaponCode::HOBNAILED_GLOVE, MeleeWeaponsTable::REQUIRED_STRENGTH, -4],
            [MeleeWeaponCode::HOBNAILED_GLOVE, MeleeWeaponsTable::LENGTH, 0],
            [MeleeWeaponCode::HOBNAILED_GLOVE, MeleeWeaponsTable::OFFENSIVENESS, 0],
            [MeleeWeaponCode::HOBNAILED_GLOVE, MeleeWeaponsTable::WOUNDS, 0],
            [MeleeWeaponCode::HOBNAILED_GLOVE, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::HOBNAILED_GLOVE, MeleeWeaponsTable::COVER, 0],
            [MeleeWeaponCode::HOBNAILED_GLOVE, MeleeWeaponsTable::WEIGHT, 0.2],
            [MeleeWeaponCode::HOBNAILED_GLOVE, MeleeWeaponsTable::TWO_HANDED, false],

            [MeleeWeaponCode::LEG, MeleeWeaponsTable::REQUIRED_STRENGTH, -5],
            [MeleeWeaponCode::LEG, MeleeWeaponsTable::LENGTH, 0],
            [MeleeWeaponCode::LEG, MeleeWeaponsTable::OFFENSIVENESS, -1],
            [MeleeWeaponCode::LEG, MeleeWeaponsTable::WOUNDS, 1],
            [MeleeWeaponCode::LEG, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::LEG, MeleeWeaponsTable::COVER, 0],
            [MeleeWeaponCode::LEG, MeleeWeaponsTable::WEIGHT, 0.0],
            [MeleeWeaponCode::LEG, MeleeWeaponsTable::TWO_HANDED, false],

            [MeleeWeaponCode::HOBNAILED_BOOT, MeleeWeaponsTable::REQUIRED_STRENGTH, -4],
            [MeleeWeaponCode::HOBNAILED_BOOT, MeleeWeaponsTable::LENGTH, 0],
            [MeleeWeaponCode::HOBNAILED_BOOT, MeleeWeaponsTable::OFFENSIVENESS, -2],
            [MeleeWeaponCode::HOBNAILED_BOOT, MeleeWeaponsTable::WOUNDS, 4],
            [MeleeWeaponCode::HOBNAILED_BOOT, MeleeWeaponsTable::WOUNDS_TYPE, WoundTypeCode::CRUSH],
            [MeleeWeaponCode::HOBNAILED_BOOT, MeleeWeaponsTable::COVER, 0],
            [MeleeWeaponCode::HOBNAILED_BOOT, MeleeWeaponsTable::WEIGHT, 0.4],
            [MeleeWeaponCode::HOBNAILED_BOOT, MeleeWeaponsTable::TWO_HANDED, false],
        ];
    }

    /**
     * @test
     */
    public function I_can_get_every_weapon_by_weapon_codes_library()
    {
        $unarmedTable = new UnarmedTable();
        foreach (MeleeWeaponCode::getUnarmedCodes() as $unarmedCode) {
            $row = $unarmedTable->getRow([$unarmedCode]);
            self::assertNotEmpty($row);
        }
    }

}